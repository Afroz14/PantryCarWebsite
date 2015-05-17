<?php namespace App\Http\Controllers;

use App\Libraries\Curl;
use App\Config\Constants;

class StationController extends Controller {


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
        $search_type = \Input::get("search_type");
		if(isset($search_type)) {
            if($search_type == 'pnr_search'){
			        $pnrNumber = \Input::get("pnr_number");
				    $url       = API_HOST.PNR_DETAIL_ROUTE.$pnrNumber;
			        $this->curl->setOption(CURLOPT_HEADER, true);
			        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			        $response = $this->curl->get($url); 
			        $response = (array)json_decode($response); 
			      }
			 else if($search_type == 'train_search')    {
			 		$trainNum    = \Input::get("train_num");
			 		$srcStation  = \Input::get("source_station");
        			$destStation = \Input::get("destination_station");
        			$journeyDate = \Input::get("journey_date");
        			if(empty($trainNum) || empty($srcStation) || empty($destStation) || empty($destStation)){
        				$response = null;
        			}
        			else{
		        		    $param     = array('src' => $srcStation,'dest' => $destStation,'date' => $journeyDate ,'train' => $trainNum) ; 
						    $url       = API_HOST.STATION_BETWEEN_LOCATION_ROUTE;
					        $this->curl->setOption(CURLOPT_HEADER, true);
					        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
					        $response = $this->curl->get($url,$param); 
					        $response = (array)json_decode($response);
        			}
			  }  
			  else{
			  	 $response = null;
			  }
		      
		      if(isset($response) && isset($response['status']) && $response['status'] === true) {
		      	   if(isset($response['doj']))
		        	 $stationHeader        = array("DATE" => $response['doj'],"TRAIN_NAME" => $response['trainName'],"TRAIN_NUMBER" =>$response['trainNum'], "ROUTE" => $response['srcStationName'] ." TO " .$response['destStationName']);
		           else
		        	  $stationHeader     =   array("DATE" => $response['date'],"TRAIN_NAME" => $response['trainName'],"TRAIN_NUMBER" =>$response['trainNum'], "ROUTE" => $response['srcStationName'] ." TO " .$response['destStationName']);
		        	
		        	$stationsListDetails  = array();
		        	foreach ($response['stations'] as $station) {
		        		$station = (array)$station;
		        		$stationsListDetails[$station['stationCode']] = array("STATION_NAME" => $station['stationName'], "ARRIVAL_TIME" =>"ARRIVAL ".$station['arrivalTime'], "HALT" => "HALT ".$station['stoppageTime'],"DAY" =>"DAY " .$station['day']);
		        	}
		            return view('station-select')->with("station_list",$stationsListDetails)->with("station_header",$stationHeader);
		       }
		       else{
		        	  return view('station-select')->with("station_list","")->with("station_header","");
		        } 

		}
		else{
			return view('station-select')->with("station_list","")->with("station_header","");
		}
            
	}

}
