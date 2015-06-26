<?php 
namespace App\Libraries;

class Helper{
	
   /* 
     @method Wrapper around http_build_query
     @param array
     @return http_build_query string
   */
	public static function httpBuildQuery($data){
       if(!empty($data)){
       	  return http_build_query($data,null, "&", PHP_QUERY_RFC3986);
       }
		return "";
	}
}