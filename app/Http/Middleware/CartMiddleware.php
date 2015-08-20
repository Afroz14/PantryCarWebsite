<?php namespace App\Http\Middleware;

use Closure;

class CartMiddleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		  $trainNum    = \Input::get("train_num");
		  $trainName   = \Input::get("train_name");
		  $journeyDate = \Input::get("journey_date"); 
		  $stationCode = \Input::get("station_code");

		  if(empty($trainNum) || empty($trainName) || empty($journeyDate) || empty($stationCode)){
		       $previousUrl = \URL::previous();
		       $previousUrl = \Helper::removeKeyFromUrl($previousUrl,'completeDetails');
		       $nextUrl     = \Helper::httpBuildUrl($previousUrl,array("query" => "completeDetails=1"),HTTP_URL_JOIN_QUERY);
		       return \Redirect::to($nextUrl);
		  }

		  if(\Auth::guest()) {
		  	   $redirectParam =  array();
		       $redirectParam["_token"]              = \Input::get("_token");
		       $redirectParam['train_num']           = \Input::get("train_num");
		       $redirectParam['train_name']          = \Input::get("train_name");
			   $redirectParam['source_station']      = \Input::get("source_station");
		       $redirectParam['destination_station'] = \Input::get("destination_station"); 
		       $redirectParam['journey_date'] 		 = \Input::get("journey_date");
		       $redirectParam['station_code']        = \Input::get("station_code");
		       $redirectParam['search_type']         = \Input::get("search_type");
		       $redirectParam['restaurant_id']       = \Input::get("restaurant_id");
		       $redirectParam['redirect_method']     = "POST"; 
		       $redirectParam['redirect_route']      = route("checkout");
		       \Session::set("socialAuthRedirectParam",$redirectParam);
		       $previousUrl = \URL::previous();
		       $previousUrl = \Helper::removeKeyFromUrl($previousUrl,'checkout');
		       $nextUrl     = \Helper::httpBuildUrl($previousUrl,array("query" => "login=1"),HTTP_URL_JOIN_QUERY);
		  	   return \Redirect::to($nextUrl)
		                 ->with('login',true)
		  			     ->with("redirect_param_availiable",true)
		  			     ->with("redirect_url",route("checkout"))
		  	             ->with("redirect_method",'POST')
		  	             ->with("redirect_controller","checkout-form");

		  }
		return $next($request);
	}

}
