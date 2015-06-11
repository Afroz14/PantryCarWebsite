<?php namespace App\Http\Controllers;
use App\Libraries\Curl;

class RestaurantController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	private $curl;

	public function __construct()
	{
		$this->curl = new Curl;
	}

	public function show()
	{


		$restaurantHeader       = array("DATE" => "20/06/2014",
			                         "TRAIN_NAME" => "KALKAJI EXPRESS",
			                          "ROUTE" => "MUMBAI TO DELHI",
			                          "STATION_SELECTED" => "NAGPUR");
		$resThumbDefault = "https://d32vr05tkg9faf.cloudfront.net/content/images/coupon/web/1080_1416550190705.png";
		$restaurantsList = array("1"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "2"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "3"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "4"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "5"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "6"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "7"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "7"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "9"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "10"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "11"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "12"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "13"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "14"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "15"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "16"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "17"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault),
			                    "18"=> array("RestaurantName" => "Agarwala Food","Rating" => "3.0","MinOrder" => "Rs.200","thumbnai"=>$resThumbDefault)
			              );
		return view('restaurant-select')->with("restaurant_header",$restaurantHeader)->with("restaurantsList",$restaurantsList);
	}

	public function getDetail($restaurantId){
       
        if($restaurantId === null || $restaurantId < 0 )
        	return "No Menu Found for this restaurant";


		/*$url       = API_HOST.RESTAURANT_MENU_API_ROUTE."RST".$restaurantId."/menu";
		$this->curl->setOption(CURLOPT_HEADER, true);
        $this->curl->setOption(CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = $this->curl->get($url); 
        $response = (array)json_decode($response);
        if($response == null || (isset($response['status']) && $response['status'] === false || $response['status'] === 500 ) || (isset($response['menu']) && $response['menu'] === null )){
            return "No Menu Found for this restaurant";
        } 

       $restaurantMenu = $response['menu'];
       $restaurantMenuHTML = "";
       foreach($restaurantMenu as $category => $menu){
            $restaurantMenuHTML .= "<h3>".$category."</h3>";
       }*/
       
       $cartController = new CartController;
       //$cartContentMobile = $cartController->getCartContentMobile();
       $cartContent       = $cartController->getCartContent();
	   return view('restaurant-page')->with('cartContent' ,$cartContent);
	}



}
