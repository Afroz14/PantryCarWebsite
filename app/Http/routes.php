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

Route::get('about-us', 'HomeController@aboutUsPage');

Route::get('/terms-and-conditons', 'HomeController@tncPage');

Route::get('/privacy-policy', 'HomeController@privacyPolicyPage');

Route::get('/disclaimer', 'HomeController@disclaimerPage');

Route::get('/contact-us', 'HomeController@contactUsPage');

Route::get('/complaints', 'HomeController@complaintsPage');

Route::post('/selectStation','StationController@show');

Route::post('/selectTrain','TrainController@show');

Route::post('/selectRestaurant','RestaurantController@show');

Route::get("/profile","ProfileController@show");

Route::get("/viewCart","CartController@show");

Route::get('/getTrainSuggestion/{query}',"RailwaysApiController@getTrainSuggestion");

Route::get('account/activate/{code}',array(
			'as' => 'activate-account',
			'uses' => 'Auth\AuthController@activateAccount'
		)
);