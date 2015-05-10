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
	}

	public function show()
	{
        $srcStation  = \Input::get("source_station");
        $destStation = \Input::get("destination_station");
        $journeyDate = \Input::get("journey_date");

        if(empty($srcStation) || empty($destStation) || empty($destStation)){
          return view('train-select')->with("train_list","")->with("train_list_header","");
        }
        else{
            $param     =  array('src' => $srcStation,'dest' => $destStation,'date' => $journeyDate ) ;   
    	    $url       = API_ROUTE.TRAIN_BETWEEN_LOCATION_ROUTE;
            $this->curl->setOption(CURLOPT_HEADER, true);
            $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = $this->curl->get($url,$param); 
            $response = (array)json_decode($response); 
            if(isset($response['status']) && $response['status'] === true) {
            	$trainListHeader        = array("DATE" => $response['date'],
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

                return view('train-select')->with("train_list",$trainListDetails)->with("train_list_header",$trainListHeader);
            }
            else{
                return view('train-select')->with("train_list","")->with("train_list_header","");
            }
      }             
   }

}
