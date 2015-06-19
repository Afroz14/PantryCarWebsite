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
	}

	public function show()
	{

       $stationCode = \Input::get("station_code");
       $trainNum    = \Input::get("train_num");
	   $srcStation  = \Input::get("source_station");
       $destStation = \Input::get("destination_station");
       $journeyDate = \Input::get("journey_date");
       if(!empty($stationCode) && !empty($trainNum) && !empty($srcStation) && !empty($destStation) && !empty($journeyDate) ){

       	   		$restaurantHeader   = array("DATE"              => $journeyDate,
			                                "TRAIN_NAME"        => $trainNum,
			                                "ROUTE"             => $srcStation ." TO ". $destStation,
			                                "STATION_SELECTED"  => $stationCode
			                          );
                $url       = API_HOST.GET_RESTAURANT_BY_STATION_API_ROUTE.$stationCode;
		        $this->curl->setOption(CURLOPT_HEADER, true);
		        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		        $response = $this->curl->get($url);  
		        $response = json_decode($response,true);
		        if(isset($response) && isset($response['status']) && $response['status'] === true){
		        	if(isset($response["restaurants"])){
		        		foreach ($response["restaurants"] as $key => $value) {
		        		   $restaurantsList	= array($key => array("restaurantName" => $value["name"]));
		        		}
		        	}
		        }
       }
     
         if(isset($restaurantsList))
		     return view('restaurant-select')->with("restaurant_header",$restaurantHeader)->with("restaurantsList",$restaurantsList);
		 else
		 	 return view('restaurant-select');
	}

	public function getDetail($restaurantId){
       
        if($restaurantId === null || $restaurantId < 0 )
        	return "No Menu Found for this restaurant";


		/*$url       = API_HOST.RESTAURANT_MENU_API_ROUTE."RST".$restaurantId."/menu";
		$this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->get($url); 
        $response = (array)json_decode($response);
        if($response == null || (isset($response['status']) && $response['status'] === false || $response['status'] === 500 ) || (isset($response['menu']) && $response['menu'] === null )){
            return "No Menu Found for this restaurant";
        } 

       $restaurantMenu = $response['menu'];
       $restaurantMenuHTML = "";
       foreach($restaurantMenu as $category => $menu){
            $restaurantMenuHTML .= "<h3>".$category."</h3>";
       }*/
       
       $cartController = new CartController;
       //$cartContentMobile = $cartController->getCartContentMobile();
       $cartContent       = $cartController->getCartContent();
	   return view('restaurant-page')->with('cartContent' ,$cartContent);
	}



}
