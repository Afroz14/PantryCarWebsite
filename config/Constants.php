<?php 

/* All api routed to be defined under this block */
define('API_HOST','http://pantrycar.elasticbeanstalk.com');

define('LOGIN_API_ROUTE','/customers/login');

define('SIGNUP_API_ROUTE','/customers/');

define('USER_DETAIL_ROUTE','/customers/');

define('TOKEN_ROUTE','/customers/get_customer_from_token');

define("PNR_DETAIL_ROUTE","/railways/get_stations_from_pnr/");

define("TRAIN_BETWEEN_LOCATION_ROUTE","/railways/get_trains_between_locations");

define("STATION_BETWEEN_LOCATION_ROUTE","/railways/get_stations_between_locations");

define("VERIFIY_ACCOUNT_ROUTE","/customers/set_customer_verified");

define("RESTAURANT_MENU_API_ROUTE","/restaurants/");

define("GET_RESTAURANT_BY_STATION_API_ROUTE","/restaurants/get_restaurants_by_station/");

/* String constants to be defined under this block */
define("ACCESS_DENIED","access_denied");

define("UPDATE_PASSWORD_RESET_TOKEN_ROUTE",'/customers/');

define("CHANGE_PASSWORD_ROUTE","/customers/");

define("GET_RESTAURANT_DETAILS_ROUTE","/restaurants/");

