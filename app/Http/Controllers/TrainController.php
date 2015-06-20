<?php namespace App\Http\Controllers;

use App\Libraries\Curl;
use App\Config\Constants;

class TrainController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		 $this->curl = new Curl;
     $this->breadcrumb = new BreadCrumb();

	}

	public function show()
	{
        $srcStation  = \Input::get("source_station");
        $destStation = \Input::get("destination_station");
        $journeyDate = \Input::get("journey_date");
        $trainNum    = \Input::get("train_num");
        $breadcrumbHTML = $this->breadcrumb->getBreadCrumb(1);
        if(empty($srcStation) || empty($destStation) || empty($destStation)){
          return view('train-select')->with("train_list","")->with("train_list_header","");

        }
        else{
           /* If train num is provided , redirect to station select direct */
            if(isset($trainNum) && !empty($trainNum))
              return \Redirect::route('select.station',array("source_station"       => $srcStation ,
                                                              "destination_station" => $destStation,
                                                              "journey_date"        => $journeyDate,
                                                              "train_num"           => $trainNum,
                                                              "search_type"         => "train_search")
                                    );

            $param     =  array('src' => $srcStation,'dest' => $destStation,'date' => $journeyDate ) ;   
    	      $url       = API_HOST.TRAIN_BETWEEN_LOCATION_ROUTE;
            $this->curl->setOption(CURLOPT_HEADER, true);
            $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = $this->curl->get($url,$param); 
            $response = (array)json_decode($response); 
            if(isset($response['status']) && $response['status'] === true) {
            	$trainListHeader        = array(   "DATE" => $response['date'],
                                                "ROUTE" => $response['srcStationName'] ." [".$response['srcStationCode']."] TO " .$response['destStationName']." [".$response['destStationCode']."]",
                                                 "SRC_STATION" => $response['srcStationCode'],
                                                 "DESTINATION_STATION" =>$response['destStationCode']
                                                );
              $trainListDetails  = array();

           	  foreach ($response['trains'] as $train) {
            		$train = (array)$train;
            		$trainListDetails[$train['trainNum']] = array("TRAIN_NAME"                    => $train['trainName'],
                                                                  "ARRIVAL_TIME_AT_SOURCE"        => "Source Arrival : ". $train['srcArrivalTime'], 
                                                                  "DEPARTURE_TIME_AT_SOURCE"      => "SourceDeparture  : ". $train['srcDepartureTime'], 
                                                                  "ARRIVAL_TIME_AT_DESTINATION"   => "Destination Arrival : ". $train['destArrivalTime'], 
                                                                  "DEPARTURE_TIME_AT_DESTINATION" => "Destination Departure : ". $train['destDepartureTime']
                                                                  );
            	}

                return view('train-select')
                             ->with("train_list",$trainListDetails)
                             ->with("train_list_header",$trainListHeader)
                             ->with("breadcrumb",$breadcrumbHTML);
            }
            else{
                return view('train-select')
                            ->with("train_list","")
                            ->with("train_list_header","")
                            ->with("breadcrumb",$breadcrumbHTML);
            }
      }             
   }

}
