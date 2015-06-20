<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

 <div class="full-width-container-other" >
        <div class="container-grid">
        	{!! $breadcrumb !!}
 	      <div class="restaurant-header-image">
 	      	  <h3 class="restaurant-name">Al Barista</h3>
 	      	  <div class="restaurant-address">New Delhi Railway Station</div>
 	      </div>

 	      <div class="restaurant-content-wrapper">
 	      	<div class="restaurant-menu-details-wrap">
 	      		<div class="restaurant-attributes">
	               <div class="each-restaurant-attributes"><i class="glyphicon glyphicon-ok _icon" ></i>Cash On Delivery Availiable</div>
	               <div class="each-restaurant-attributes"><i class="glyphicon glyphicon-tags _icon"></i>Min Booking Amount : Rs 200</div>
	               <div class="each-restaurant-attributes no-border-right"><i class="glyphicon glyphicon-ok _icon" ></i>Delivery Charges : Free</div>
 	           </div>	
 	      	  <div class="restaurant-menu-label"><i class="icon-food _icon"></i>Menu</div>
 	      	   <div class="floatleft" id="res-category-container">
 	      	     <ul class="res-category">
			            <li class="active">
			                <a href="#veg" data-toggle="tab" >Veg<i class="glyphicon icon-angle-right floatright res-category-arrow"></i></a>
			            </li>
			            <li>
			                <a href="#nonveg" data-toggle="tab" >Non - Veg<i class="glyphicon icon-angle-right floatright res-category-arrow"></i></a>
			            </li>
			            <li >
			                <a href="#beverages" data-toggle="tab">Beverages<i class="glyphicon icon-angle-right floatright res-category-arrow"></i></a>
			            </li>
                  </ul>
                </div> 
                 <div class="floatleft tab-content" id="res-menu-item-container">
		 	      		<div class="tab-pane active each-menu-category-wrap" id="veg">
		 	      		  <div class="menu-category">Veg</div>
		 	      		    <div class="each-category-menu-item"><span class="item-name" data-product-id="1" data-product-title="Veg Thali" data-product-price="160">Veg Thali</span><span class="item-price">Rs 160</span> <div class="add-to-cart-label">add to cart</div></div>
		 	      		   <div class="each-category-menu-item"><span class="item-name" data-product-id="2" data-product-title="Chole Bhature" data-product-price="200">Chole Bhature</span><span class="item-price">Rs 200</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		  
		 	      		</div> 

		 	      		<div class="tab-pane each-menu-category-wrap" id="nonveg">
		 	      		  <div class="menu-category">Non - Veg</div>
		 	      		  <div class="each-category-menu-item"><span class="item-name" data-product-id="3" data-product-title="Non -Veg Thali" data-product-price="160">Non - Veg Thali</span><span class="item-price">Rs 240</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		  <div class="each-category-menu-item "><span class="item-name" data-product-id="4" data-product-title="Chicken Changezi" data-product-price="160">Chicken Changezi</span><span class="item-price">Rs 200</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		  <div class="each-category-menu-item"><span class="item-name" data-product-id="5" data-product-title="Butter Chicken" data-product-price="160">Butter Chicken</span><span class="item-price">Rs 180</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		  <div class="each-category-menu-item"><span class="item-name" data-product-id="6" data-product-title="Chicken Afgani" data-product-price="160">Chicken Afgani</span><span class="item-price">Rs 280</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		</div>  


		               <div class="tab-pane each-menu-category-wrap" id="beverages">
		 	      		  <div class="menu-category"  >Beverages</div>
		 	      		  <div class="each-category-menu-item"><span class="item-name" data-product-id="7" data-product-title="Cold Drink" data-product-price="160">Cold Drink</span><span class="item-price">Rs 20</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		  <div class="each-category-menu-item "><span class="item-name" data-product-id="8" data-product-title="Lemonade" data-product-price="160">Lemonade</span><span class="item-price">Rs 30</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		  <div class="each-category-menu-item"><span class="item-name" data-product-id="9" data-product-title="Apple Juice" data-product-price="160">Apple Juice</span><span class="item-price">Rs 30</span><div class="add-to-cart-label">add to cart</div></div>
		 	      		</div>  
 	         	</div>
 	      </div>
 	      	<div class="user-cart-large-wrap">
 	          <div class="user-cart">
	            <h4>Your Orders</h4>
	             {!! $cartContent !!}
 	         </div>
 	     </div>
 	      <div class="cart-mobile-footer omit">
 	      	<div class="cart-mobile-summary">
 	      		<i class="icon-shopping-cart shopping-cart-icon-mobile"></i> 
 	      		   @if(Cart::total() > 0)
 	      		    <span class="cd-cart-total"><p>Total Rs <span>{{ Cart::total() }}</span></p></span>
 	      		    @else
 	      		    <span class='mobile-cart-empty'>Your cart is empty .</span>
 	      		    @endif
 	        </div>
 	         @if(Cart::total() > 0)
 	            <a href="" class="checkout-btn">Checkout</a>
 	          @endif	
 	      </div>	
      </div>
</div>

<div id="cd-shadow-layer"></div>

<!-- cd-cart -->
<div id="cd-cart">
	 <h2>Cart</h2>
	 <div class="horizontal-loader hidden"></div>
	 <div id="cd-cart-items-wrap"></div>
</div> 	 
</div>
<!-- cd-cart -->

@include('footer')
<script src="{{ asset('/js/build/cart.min.js') }} "></script>
</body>
</html>