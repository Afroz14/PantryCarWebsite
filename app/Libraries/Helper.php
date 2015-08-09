<?php 
namespace App\Libraries;

/*
* Contains all Utilities
*/

class Helper{
	

   const encodingType = PHP_QUERY_RFC3986;
   /* 
     @method Wrapper around http_build_query
     @param array
     @return http_build_query string
   */
	public static function httpBuildQuery($data){
       if(!empty($data)){
       	  return http_build_query($data,null, "&", self::encodingType);
       }
		return "";
	}
}