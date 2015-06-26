<?php namespace App\Http\Controllers;


 /*
 *  User Cart Controller
 *  Author : Afroz
 */



class CartController extends Controller {


	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function show()
	{
        $cartContent           = self::getCartContent();
        $overWriteFlag         = \Input::get('s');
        $fixCheckoutButtonFlag = false;
        if(!empty($overWriteFlag) && $overWriteFlag == 1)
          $fixCheckoutButtonFlag = true;

        $cartContent       = self::getCartContent($fixCheckoutButtonFlag); 
        return view('user-cart')->with('cartContent' ,$cartContent);
	}

/*
* Single entry point for Cart controller
*/
  public function handle(){

     $productData   = \Input::get('productDetail');
     $case          = \Input::get('case');
     $response      = array("status" => "false");

     switch($case){
        case "ADD_ITEM"    : $response = self::addItem($productData);break;
        case "REMOVE_ITEM" : $response = self::removeItem($productData);break;
        case "INC_ITEM"    : $response = self::addItem($productData,"incrementCount");break;
        case "DEC_ITEM"    : $response = self::removeItem($productData,"decrementCount");break; 
        case "UPDATE_ITEM" : $response = self::updateItemQty($productData);break;        
     }
     
     return $response;
  }

 /*
 *  Add an item to cart
 *  Three cases are handled while adding any product to cart
 *  1) When item to be added doesnt exist and is added for the first time by selecting add to cart option
 *  2) When item to be added  exist and is agin added by selecting add to cart option
 *  3) When item count is increased by clicking "+" sign in the cart respective of cart items
 *  @return array  
 */

	private function addItem($productData,$case=""){

        $data          = $productData;
        $productId     = isset($data) && isset($data['productId'])?$data['productId']:'';
        $productExists = false;
        $isProductAlreadyExistsinCart = false;
        
        if(!empty($productId)){
           $isProductAlreadyExistsinCart = \Cart::search(array("id" => $productId));
           if(isset($isProductAlreadyExistsinCart))
             $getCurrentStatusOfProduct = \Cart::get($isProductAlreadyExistsinCart[0]);
         }


        if(!empty($data) && $isProductAlreadyExistsinCart && empty($case)){
       	    $productId    = isset($data['productId'])?$data['productId']:'';
        	  $productTitle = isset($data['productTitle'])?$data['productTitle']:'';
        	  $productPrice = isset($data['productPrice'])?$data['productPrice']:'';

            if(isset($getCurrentStatusOfProduct['qty']) && !empty($productId) && !empty($productTitle) &&  !empty($productPrice))
              {
              	$oldQty = $getCurrentStatusOfProduct['qty'];
              	$newQty = $oldQty +  1;
              	\Cart::update($isProductAlreadyExistsinCart[0],$newQty);
              	$updatedPriceForThisProduct  = \Cart::get($isProductAlreadyExistsinCart[0])['subtotal']; 
              	$updatedTotalPrice           = '<p>Total <span>Rs '.\Cart::total().'</span></p>'; 
                $cartArray                   =  json_decode(json_encode(\Cart::content()), true);
                $itemIndex                   = array_search($isProductAlreadyExistsinCart[0], array_keys($cartArray));
                $cartItemCount               = self::getItemCountInCart();
                

	        	    $cartItem  =  "<li data-index='".$itemIndex."' >";
      				  $cartItem .= '<div class="user-cart-item-name">'.$productTitle.'</div>';
      				  $cartItem .= '<span data-product-id = "'.$productId.'" class="cd-qty"><span class="dec-button"></span><input type="text" class="user-cart-qty" value="'.$newQty.'" /><span class="inc-button"></span></span>';
      				  $cartItem .= '<div class="cd-price">Rs '.$updatedPriceForThisProduct.'</div>';
      				  $cartItem .= '</li>';

                $response = array( "status"        => "true",
                                   "cartItem"      => $cartItem,
                                   "totalPrice"    => $updatedTotalPrice,
                                   "cartItemCount" => $cartItemCount,
                                   "itemIndex"     => $itemIndex 
                                  );
				        return $response;
              }
       }


       else if(!empty($case) && $case === 'incrementCount' && !empty($productId) && $isProductAlreadyExistsinCart){
              if(isset($getCurrentStatusOfProduct['qty']))
              {
              	$oldQty = $getCurrentStatusOfProduct['qty'];
              	$newQty = $oldQty +  1;
              	\Cart::update($isProductAlreadyExistsinCart[0],$newQty);
              	$cartItemCount              = self::getItemCountInCart();
                $updatedPriceForThisProduct = "Rs ".\Cart::get($isProductAlreadyExistsinCart[0])['subtotal']; 
              	$updatedTotalPrice          = '<p>Total <span>Rs '.\Cart::total().'</span></p>'; 

			          $response  = array( "status"        => "true",
                                    "itemSubtotal"  => $updatedPriceForThisProduct,
                                    "totalPrice"    => $updatedTotalPrice, 
                                    "cartItemCount" => $cartItemCount,
                                    "newQty"        => $newQty
                                  );
                return $response; 
              }
        }

        else if(!empty($data)){
        	$productTitle = isset($data['productTitle'])?$data['productTitle']:'';
        	$productPrice = isset($data['productPrice'])?$data['productPrice']:'';

        	if(!empty($productId) && !empty($productTitle) &&  !empty($productPrice)){
              $itemIndex = \Cart::count(false) ;
        		  \Cart::add($productId, $productTitle, 1, $productPrice);
	        	  $cartItem  =  "<li data-index='".$itemIndex."'>";
    				  $cartItem .= '<div class="user-cart-item-name">'.$productTitle.'</div>';
    				  $cartItem .= '<span data-product-id = "'.$productId.'" class="cd-qty"><span class="dec-button"></span><input type="text" class="user-cart-qty" value="1" /><span class="inc-button"></span></span>';
    				  $cartItem .= '<div class="cd-price">Rs '.$productPrice.'</div>';
    				  $cartItem .= '</li>';
              $updatedTotalPrice = '<p>Total <span>Rs '.\Cart::total().'</span></p>'; 
    				  $cartItemCount     = self::getItemCountInCart();
				      $response = array(  "status"        => "true",
                                  "cartItem"      => $cartItem,
                                  "totalPrice"    => $updatedTotalPrice,
                                  "cartItemCount" => $cartItemCount,
                                  "itemIndex"     => $itemIndex 
                                );
              return $response;
        	}

        }
         return array("status" => "false");

	}

	private function getItemCountInCart(){
		if(\Cart::count() > 0)
			return '<span id="label-cart-item-count">'.\Cart::count(false).'<span>';
		else
			return '';
	}

 /*
 *  Remove an item from cart
 *  Two cases are handled while removing any product from cart
 *  1) When qty of the item to be removed is one and user select confirm button .
 *  2) When item count is decresed  by clicking "-" sign in the cart respective of cart items
 *  @return array  
 */
 

	private function removeItem($productData,$case=""){
        
        $data          = $productData;
        $productId     = isset($data) && isset($data['productId'])?$data['productId']:'';

        if(!empty($productId)){
          $rowId = \Cart::search(array("id" => $productId));
        	if(isset($rowId) && !empty($case) && $case === 'decrementCount'){
              
              $getCurrentStatusOfProduct = \Cart::get($rowId[0]);
              if(isset($getCurrentStatusOfProduct) && isset($getCurrentStatusOfProduct['qty']))
              {
              	$oldQty = $getCurrentStatusOfProduct['qty'];
              	$newQty = $oldQty -  1;
              	\Cart::update($rowId[0],$newQty);
              	$cartItemCount              = self::getItemCountInCart();
                $updatedPriceForThisProduct = "Rs ".\Cart::get($rowId[0])['subtotal']; 
                $updatedTotalPrice          = '<p>Total <span>Rs '.\Cart::total().'</span></p>'; 

                $response = array( "status"        => "true",
                                   "itemSubtotal"  => $updatedPriceForThisProduct,
                                   "totalPrice"    => $updatedTotalPrice, 
                                   "cartItemCount" => $cartItemCount,
                                   "newQty"        => $newQty
                                  );
                return $response;
              }
        	}
        	else if(isset($rowId)){
        		\Cart::remove($rowId[0]);
            $updatedTotalPrice    = '<p>Total <span>Rs '.\Cart::total().'</span></p>'; 
            $cartItemCount        = self::getItemCountInCart();
            $response = array( "status"        => "true",
                               "totalPrice"    => $updatedTotalPrice, 
                               "cartItemCount" => $cartItemCount 
                              );
            return $response;
        	}

		}

		return array("status" => "false");
	}


  private function updateItemQty($productData){
     $productId     = isset($productData) && isset($productData['productId'])?$productData['productId']:'';
     $newQty        = isset($productData) && isset($productData['newQty'])?$productData['newQty']:'';

     $response = array("status" => "false");

     if(!empty($productId) && !empty($newQty) ){
        $rowId = \Cart::search(array("id" => $productId));
        if(isset($rowId)){
            $getCurrentStatusOfProduct = \Cart::get($rowId[0]);
            \Cart::update($rowId[0],$newQty);
            $cartItemCount              = self::getItemCountInCart();
            $updatedPriceForThisProduct = "Rs ".\Cart::get($rowId[0])['subtotal']; 
            $updatedTotalPrice          = '<p>Total <span>Rs '.\Cart::total().'</span></p>'; 

            $response  = array(       "status"        => "true",
                                      "itemSubtotal"  => $updatedPriceForThisProduct,
                                      "totalPrice"    => $updatedTotalPrice, 
                                      "cartItemCount" => $cartItemCount,
                                      "newQty"        => $newQty
                            );
        }
     }

     return $response;

  }


	public function getCartContentMobile(){

		
    $content    = \Cart::content();
    $cartString = "<ul class='cd-cart-items'>";
    $cartItem   = "";
    $iterator   = 0;

    foreach($content as $row)
    {
        $cartItem .=  "<li data-index='".$iterator."'>";
        $cartItem .= '<div class="user-cart-item-name">'.$row->name.'</div>';
        $cartItem .= '<span data-product-id = "'.$row->id.'" class="cd-qty"><span class="dec-button"></span><input type="text" class="user-cart-qty" value="'.$row->qty.'" /><span class="inc-button"></span></span>';
        $cartItem .= '<div class="cd-price">Rs '.$row->subtotal.'</div>';
        $cartItem .= '</li>';
        $iterator++;
    }

        if(empty($cartItem)){
          $cartString .= "<span class='cart-empty'>Your cart is empty .</span>";
          $cartString .= "</ul>";
        }
        else{
              $cartString .= $cartItem;
              $cartString .= "</ul>";
          }

     return $cartString;
	}

	public function getCartContent($fixCheckoutButtonFlag = false){

		$content    = \Cart::content();
		$cartString = "<ul class='cd-cart-items'>";
		$cartItem   = "";
		$iterator   = 0;

		foreach($content as $row)
		{
			  $cartItem .=  "<li data-index='".$iterator."'>";
			  $cartItem .= '<div class="user-cart-item-name">'.$row->name.'</div>';
			  $cartItem .= '<span data-product-id = "'.$row->id.'" class="cd-qty"><span class="dec-button"></span><input type="text" class="user-cart-qty" value="'.$row->qty.'" /><span class="inc-button"></span></span>';
			  $cartItem .= '<div class="cd-price">Rs '.$row->subtotal.'</div>';
			  $cartItem .= '</li>';
			  $iterator++;
		}

        if(empty($cartItem)){
        	$cartString .= "<span class='cart-empty'>Your cart is empty .</span>";
        	$cartString .= "</ul>";
        }
        else{
        	    $cartString .= $cartItem;
        	    $cartString .= "</ul>";
        	    $cartString .= '<div class="cd-cart-total"><p>Total <span>Rs '.\Cart::total().'</span></p></div>';
              $cartString .= '<a href="" class="checkout-btn '.(($fixCheckoutButtonFlag)? " fix-checkout-button-width":"").'">Checkout</a>';
          }

		 return $cartString;
	}

}
