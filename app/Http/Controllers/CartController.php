<?php namespace App\Http\Controllers;


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
        return view('user-cart');
	}

	public function addItem(){

        $data = \Input::get('productDetail');
        if(!empty($data)){
        	$productId   = isset($data['productId'])?$data['productId']:'';
        	$productTitle = isset($data['productTitle'])?$data['productTitle']:'';
        	$productPrice = isset($data['productPrice'])?$data['productPrice']:'';

        	if(!empty($productId) && !empty($productTitle) &&  !empty($productPrice)){
        		\Cart::add($productId, $productTitle, 1, $productPrice);
        	}

        }
        return self::getItemCountInCart();

	}

	public function getItemCountInCart(){
		if(\Cart::count() > 0)
			return '<span id="label-cart-item-count">'.\Cart::count().'<span>';
		else
			return '';
	}

	public function removeItem(){
        
        $productId = \Input::get('productId');
        if(!empty($productId)){
		    \Cart::remove($productId);
			 $cartContent   = self::getCartContent();
			 $cartItemCount = self::getItemCountInCart();
			 return array("status" => "true","cartContent" => $cartContent,"cartItemCount" => $cartItemCount );
		}

		return array("status" => "false");
	}

	public function getCartContent(){

		$content = \Cart::content();

		$cartString = "<ul class='cd-cart-items'>";
		$cartItem = "";
		foreach($content as $row)
		{
			  $cartItem .=  "<li>";
			  $cartItem .= '<span class="cd-qty">'.$row->qty .'x</span>'.$row->name;
			  $cartItem .= '<div class="cd-price">'.$row->price.'</div>';
			  $cartItem .= '<a href="#" data-product-id = "'.$row->rowid.'" class="cd-item-remove cd-img-replace">Remove</a>';
			  $cartItem .= '</li>';
		}

        if(empty($cartItem)){
        	$cartString .= "<span class='cart-empty'>Your cart is empty .<span>";
        	$cartString .= "</ul>";
        }
        else{
        	    $cartString .= $cartItem;
        	    $cartString .= "</ul>";
        	    $cartString .= '<div class="cd-cart-total"><p>Total <span>Rs '.\Cart::total().'</span></p></div>';
                $cartString .= '<a href="" class="checkout-btn">Checkout</a>';
          }

		return $cartString;
	}

}
