<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

    <div class="full-width-container-other">
        <section style="padding-bottom: 50px;">
            <div class="col-md-offset-1 col-md-10">
							<h3 class="head-common-color pc-heading">Inside Your cart</h3>
							@if(\Cart::count(false) >0 )
							<div class="col-md-8 ml-negative-15">
								  <div class="mb20 overflow-hidden ">
									 <div class="floatleft cart-restaurant-image" >
										 <img src="{{ asset('img/blurback.jpg')}}" width="174" height="94"  />
								     </div>	
								     <div class="pl10 cart-restaurant-info-wrap">
								     	<div class="restaurant-name-small-1">Al Barista</div>
								     	<div class="restaurant-attributes-small">
								     		<span><i class="fa fa-check-circle pr10"></i>Cash On Delivery : Availiable</span>
								     		<span><i class="fa fa-check-circle pr10"></i>Delivery Charges : Free</span>
								     	</div>
								        <div class="cart-item-count mt10 mb10">Total items : {{ $itemCount }} </div>
								     </div>
								 </div>		  
									  <div class="user-cart full-width-cart clear">
										          {!! $cartContent !!}
									 </div>
							 </div>
							<div class="col-md-4 ml-negative-15" id="cart-order-details">
								 <h4 class="head-common-color text-center">Order Details</h4>
									<ul class="booking-info-list">
							        		 <li>
							        		 	 <span>
							        		 	 	 <p class="booking-info-component-label">Date of Journey</p>
							        		 	 	 <p class="booking-info-component-value">2013-07-01</p>
							        		 	 </span>	
							                 </li>
							                 <li>
							        		 	 <span>
							        		 	 	 <p class="booking-info-component-label">Train Number</p>
							        		 	 	 <p class="booking-info-component-value">1233</p>
							        		 	 </span>	
							                 </li>
							                 <li>
							        		 	 <span>
							        		 	 	 <p class="booking-info-component-label">Train Name</p>
							        		 	 	 <p class="booking-info-component-value">Gorakhdham Express</p>
							        		 	 </span>	
							                 </li>
							                 <li>
							        		 	 <span>
							        		 	 	 <p class="booking-info-component-label">Station Selected</p>
							        		 	 	 <p class="booking-info-component-value">Chennai</p>
							        		 	 </span>	
							                 </li>
							 	      </ul>
							 	      <a href="" class="checkout-btn mt20">Checkout</a>
							</div>
							@else
							 <div class="user-cart full-width-cart clear">
							 	<ul class='cd-cart-items'>
							 		<span class='cart-empty'>Your cart is empty .</span>
							    </ul>
							    <div class="form-group buttons text-center mt20">
				                    <a href="{{ url('/') }} " class="pc-btn">
				                        GO HOME
				                    </a>
	                         </div>		
							 </div>
							@endif
				</div>  
		</section>	 
     </div>

<form id="checkout-form" method="POST" action="{{ url('/checkout') }}">
	<input type="hidden" value="{{ csrf_token() }}" name="_token" >
	<?php $parameters = \Session::get("checkoutFormParamters") ;?> 
	<?php if(!empty($parameters)) : ?>
		@foreach($parameters as $param => $val)
		    <input type ="hidden" name ="{{ $param }}" value="{{ $val }}" />
		@endforeach
     <?php endif ;?>	
</form>


@include('footer')
<script src="{{ asset('/js/build/cart.min.js') }} "></script>
</body>
</html>   			

