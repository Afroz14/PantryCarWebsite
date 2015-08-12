<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



Route::get('/', 'HomeController@index');

Route::get('/login', function() {
     return Redirect::to('/')->with('login', 1);
});

Route::get('/logout', function() {
	   Auth::logout();
     return Redirect::to('/');
});

Route::get('/signup', function() {
     return Redirect::to('/')->with('signup', 1);
});

Route::get('facebook', 'Auth\AuthController@facebook_redirect');
Route::get('account/facebook', 'Auth\AuthController@facebook');

Route::get('google', 'Auth\AuthController@google_redirect');
Route::get('account/google', 'Auth\AuthController@google');

Route::post('login', array('uses'=>'Auth\AuthController@login','as' => 'login.form'));
Route::post('signup', 'Auth\AuthController@signup');

Route::get('/terms-and-conditons', 'HomeController@tncPage');

Route::get('/privacy-policy', 'HomeController@privacyPolicyPage');

Route::get('/disclaimer', 'HomeController@disclaimerPage');

Route::get('/contact-us', 'HomeController@contactUsPage');

Route::get('/order-tracker','HomeController@orderTrackerPage');

Route::get("/merchants","HomeController@merchantPage");

Route::get('/complaints', 'HomeController@complaintsPage');

Route::get('/selectStation',array('as' => 'select.station', 'uses' => 'StationController@show'));

Route::get('/selectTrain',array('as'=>'select.train' ,'uses' =>'TrainController@show'));

Route::get("/profile","ProfileController@show");

Route::get("/viewCart","CartController@show");

Route::get('/getTrainSuggestion/{query}',"RailwaysApiController@getTrainSuggestion");

Route::get('account/activate/{code}',array('as'   => 'activate-account','uses' => 'Auth\AuthController@activateAccount'));

Route::get('passwordReset/{code}',array('as'   => 'password-reset','uses' => 'Auth\AuthController@passwordReset'));


Route::get("/signup-login-redirect","Auth\AuthController@signupLoginRedirect");

Route::get('/restaurant/{restaurantId}',"RestaurantController@getDetail");

Route::post('/cartHandler',"CartController@handle");

Route::get('/getCartMobile',"CartController@getCartContentMobile");

Route::get('/getPnrDetail/{pnr_number}',"StationController@getPnrDetail");

Route::get('/restaurants/{station_code}/{slug}','RestaurantController@show');

Route::get("/processPayment","PaymentController@handle");

Route::group(array('before' => 'checkout_auth'), function() { Route::post("/checkout",array('as' => 'checkout' ,'uses' => 'CartCheckout@handle')); });

/* Prior moving on to checkout page , make sure that user is authenticated first */
Route::filter('checkout_auth',function(){
  if(Auth::guest()) {
  	   $redirectParam =  array();
       $redirectParam["_token"]              = \Input::get("_token");
       $redirectParam['train_num']           = \Input::get("train_num");
       $redirectParam['train_name']          = \Input::get("train_name");
	     $redirectParam['source_station']      = \Input::get("source_station");
       $redirectParam['destination_station'] = \Input::get("destination_station"); 
       $redirectParam['journey_date'] 		   = \Input::get("journey_date");
       $redirectParam['station_code']        = \Input::get("station_code");
       $redirectParam['search_type']         = \Input::get("search_type");
       $redirectParam['restaurant_id']       = \Input::get("restaurant_id");
       $redirectParam['redirect_method']     = "POST"; 
       $redirectParam['redirect_route']      = route("checkout");
       Session::set("socialAuthRedirectParam",$redirectParam);

  	   return Redirect::back()->with('login', true)
  						   ->with("redirect_param_availiable",true)
  						   ->with("redirect_url",route("checkout"))
  	             ->with("redirect_method",'POST')
  	             ->with("redirect_controller","checkout-form");

  }

});

Route::get('/forgotPassword','Auth\AuthController@forgotPassword');

Route::post('password/email','Auth\AuthController@sendPasswordResetToken');

Route::post('password/reset','Auth\AuthController@changePassword');
