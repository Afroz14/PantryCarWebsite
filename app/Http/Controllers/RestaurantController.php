<?php namespace App\Http\Controllers;
use App\Libraries\Curl;

class RestaurantController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	private $curl;

	public function __construct()
	{
		$this->curl = new Curl;
		$this->breadcrumb = new BreadCrumb();
	}

	public function show($stationCode)
	{
       $trainNum    = \Input::get("train_num");
       $trainName   = \Input::get("train_name");
	   $srcStation  = \Input::get("source_station");
       $destStation = \Input::get("destination_station"); 
       $journeyDate = \Input::get("journey_date");
       $breadcrumbHTML = $this->breadcrumb->getBreadCrumb(2);

       if(!empty($stationCode)){

                $restaurantHeader = "";
                $parentUrlParam   = "";
                if(!empty($journeyDate) && !empty($trainNum) &&  !empty($trainName) &&  !empty($srcStation) &&  !empty($destStation) ){
	       	   		$restaurantHeader   = array("DATE"              => $journeyDate,
				                                "TRAIN_NUM"         => $trainNum,
				                                "TRAIN_NAME"       =>  $trainName,
				                                "ROUTE"             => $srcStation ." TO ". $destStation,
				                                "STATION_SELECTED"  => $stationCode
				                          );
	       	   		$parentUrlParam    = \Helper::httpBuildQuery(array(  "train_num"           => $trainNum,
		        			                                       		 "source_station"      => $srcStation,
		        			                                       		 "destination_station" => $destStation,
		        			                                       		 "journey_date"        => $journeyDate,
		        			                                       		 "train_name"         => $trainName,
		        			                                       		 "station_code"       => $stationCode
		        			                                 ));
       	   	    }
                $url       = API_HOST.GET_RESTAURANT_BY_STATION_API_ROUTE.$stationCode;
		        $this->curl->setOption(CURLOPT_HEADER, true);
		        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		        $response = $this->curl->get($url);  
		        $response = json_decode($response,true);
		        if(isset($response) && isset($response['status']) && $response['status'] === true){
		        	if(isset($response["restaurants"])){
		        		foreach ($response["restaurants"] as $value) {
		        		   $restaurantsList[] = array("restaurantName" => $value["name"],
		        		   	 						  "restaurantUrl"  => \URL::to("/")."/restaurant/".$value["url"]."?".$parentUrlParam
		        		   	                 );
		        		}
		        	}
		        }
       }

         if(isset($restaurantsList)){
		     return view('restaurant-select')
		             ->with("restaurant_header",$restaurantHeader)
		             ->with("restaurantsList",$restaurantsList)
		             ->with("breadcrumb",$breadcrumbHTML);
		 }
		 else{
		 	 return view('restaurant-select')
		 	            ->with("breadcrumb",$breadcrumbHTML);
		 	}
	}

	public function getDetail($restaurantId){
       
        if($restaurantId === null || $restaurantId < 0 )
        	return "No Menu Found for this restaurant";
       
       $cartController = new CartController;
       $cartContent    = $cartController->getCartContent();
       $breadcrumbHTML = $this->breadcrumb->getBreadCrumb(3);

       $trainNum    = \Input::get("train_num");
       $trainName   = \Input::get("train_name");
	   $srcStation  = \Input::get("source_station");
       $destStation = \Input::get("destination_station"); 
       $journeyDate = \Input::get("journey_date");
       $stationCode = \Input::get("station_code");
       $restaurantHeader = null;
       if(!empty($journeyDate) && !empty($trainNum) &&  !empty($trainName) &&  !empty($srcStation) &&  !empty($destStation) && !empty($stationCode) && !empty($journeyDate) ){
	       	   		$restaurantHeader   = array("DATE"              => $journeyDate,
				                                "TRAIN_NUM"         => $trainNum,
				                                "TRAIN_NAME"       =>  $trainName,
				                                "ROUTE"             => $srcStation ." TO ". $destStation,
				                                "STATION_SELECTED"  => $stationCode
				                          );
	      } 	   		
	   return view('restaurant-page')
	           ->with('cartContent' ,$cartContent)
	           ->with("breadcrumb",$breadcrumbHTML)
	           ->with("restaurant_header",$restaurantHeader);
	}



}
