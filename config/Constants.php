<?php 
/* All constants goes here */

define('API_HOST','http://52.11.133.21/api');
//define('API_ROUTE','http://api.pantrycar.co.in');
define('LOGIN_API_ROUTE','/customers/login');

define('SIGNUP_API_ROUTE','/customers/');

define('USER_DETAIL_ROUTE','/customers/');

define('TOKEN_ROUTE','/customers/get_customer_from_token');

define('FACEBOOK_APP_ID','932156280156672');

define('FACEBOOK_APP_SECRET','8f4a9d5e2dc5b6471baf1076d8ecf5da');

define("ACCESS_DENIED","access_denied");

define("TRAIN_SEARCH_API_ROUTE","http://runningstatus.in/trainsuggest.php");

define("PNR_DETAIL_ROUTE","/railways/get_stations_from_pnr/");

define("TRAIN_BETWEEN_LOCATION_ROUTE","/railways/get_trains_between_locations");

define("STATION_BETWEEN_LOCATION_ROUTE","/railways/get_stations_between_locations");

define("VERIFIY_ACCOUNT_ROUTE","/customers/set_customer_verified");
?>