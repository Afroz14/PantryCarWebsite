/*
*  Cart Controller and related events
*/
function UserCart(){}


UserCart.prototype.addItemToCart = function(productToBeAddedInCart,itemSelector) {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/cartHandler',
            data:{'_token':X_ACCESS_TOKEN,"productDetail":productToBeAddedInCart,"case":"ADD_ITEM"},
            method:'POST',
            success:function(data){
            	 /* Clear previous cart state */
            	 if( data.status !== 'undefined' && data.status === 'true'){
            	 	 $('#cart-trigger').find('#label-cart-item-count').remove();
            	     $('#cart-trigger').append(data.cartItemCount);
            	     animatedlyAddItemToCart(data.cartItem,itemSelector,data.itemIndex);
                     checkIfTheItemTobeAddedIsFirstItem();
                     $(".cd-cart-total").html(data.totalPrice);
            	 }

            },
            error:function(){
            }
         });
};

UserCart.prototype.showItemInCart = function() {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/getCartMobile',
            method:'GET',
            success:function(data){
            	 $('#cd-cart #cd-cart-items-wrap').html(data);
            	 $('#cd-cart .horizontal-loader').addClass('hidden');
            },
            error:function(){
            	 $('#cd-cart .horizontal-loader').addClass('hidden');
            }
         });
};

UserCart.prototype.removeItemFromCart = function(productToBeRemoved,itemSelector) {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/cartHandler',
             data:{'_token':X_ACCESS_TOKEN,"productDetail":productToBeRemoved,"case":"REMOVE_ITEM"},
            method:'POST',
            success:function(data){
            	if(data.status !== 'undefined' && data.status == 'true'){
            		$('#cart-trigger').find('#label-cart-item-count').remove();
                    $('#cart-trigger').append(data.cartItemCount);
                    $(".cd-cart-total").html(data.totalPrice);
                    $(itemSelector).closest('li').remove();
                    checkIfTheItemToBeRemovedIsLastItem();
            	}
            },
            error:function(){
            }
         });
};

UserCart.prototype.decrementItemCountFromCart = function(productToBeUpdated,itemSelector) {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/cartHandler',
             data:{'_token':X_ACCESS_TOKEN,"productDetail":productToBeUpdated,"case":"DEC_ITEM"},
            method:'POST',
            success:function(data){
            	if(data.status !== 'undefined' && data.status == 'true'){
            		$('#cart-trigger').find('#label-cart-item-count').remove();
                    $('#cart-trigger').append(data.cartItemCount);
                    $(".cd-cart-total").html(data.totalPrice);
                    $(itemSelector).siblings('.user-cart-qty').val(data.newQty);
                    $(itemSelector).parent().siblings('.cd-price').html(data.itemSubtotal);
            	}
            	
            },
            error:function(){
            }
         });
};

UserCart.prototype.incrementItemCountFromCart = function(productToBeUpdated,itemSelector) {
       $.ajax({
            cache: false,
            url: BASE_PATH + '/cartHandler',
             data:{'_token':X_ACCESS_TOKEN,"productDetail":productToBeUpdated,"case":"INC_ITEM"},
            method:'POST',
            success:function(data){
                if(data.status !== 'undefined' && data.status == 'true'){
                    $('#cart-trigger').find('#label-cart-item-count').remove();
                    $('#cart-trigger').append(data.cartItemCount);
                    $(".cd-cart-total").html(data.totalPrice);
                    $(itemSelector).siblings('.user-cart-qty').val(data.newQty);
                    $(itemSelector).parent().siblings('.cd-price').html(data.itemSubtotal);
                }
            },
            error:function(){
            }
         });
};

UserCart.prototype.updateItemQty = function(productToBeUpdated,itemSelector){
     $.ajax({
            cache: false,
            url: BASE_PATH + '/cartHandler',
             data:{'_token':X_ACCESS_TOKEN,"productDetail":productToBeUpdated,"case":"UPDATE_ITEM"},
            method:'POST',
            success:function(data){
                if(data.status !== 'undefined' && data.status == 'true'){
                    $('#cart-trigger').find('#label-cart-item-count').remove();
                    $('#cart-trigger').append(data.cartItemCount);
                    $(".cd-cart-total").html(data.totalPrice);
                    $(itemSelector).siblings('.user-cart-qty').val(data.newQty);
                    $(itemSelector).parent().siblings('.cd-price').html(data.itemSubtotal);
                }
            },
            error:function(){
            }
         });
};

function checkIfTheItemToBeRemovedIsLastItem(){

    if($('#cd-cart-items-wrap .cd-cart-items').children().length === 0){
        $('.cart-mobile-summary').append("<span class='mobile-cart-empty'>Your cart is empty .</span>");
        $('#cd-cart-items-wrap .cd-cart-items').append("<span class='cart-empty'>Your cart is empty .</span>");
        $(".cart-mobile-summary .cd-cart-total").remove();
        $(".cart-mobile-footer .checkout-btn").remove();
    }

    if($('.user-cart .cd-cart-items').children().length === 0){
          $('.cd-cart-items').html("<span class='cart-empty'>Your cart is empty .</span>");
          $(".user-cart .cd-cart-total").remove();
          $(".user-cart .checkout-btn").remove();
      }  
}

function checkIfTheItemTobeAddedIsFirstItem(){
    if($(".cart-empty").length > 0){
        $(".cart-empty").remove();
        $('.user-cart').append('<div class="cd-cart-total"></div>');
        $('.user-cart').append('<a href="" class="checkout-btn">Checkout</a>');
    }
    if($(".mobile-cart-empty").length >0 ){
            $(".mobile-cart-empty").remove();
            $('.cart-mobile-summary').append('<div class="cd-cart-total"></div>');
            $(".cart-mobile-footer").append('<a href="" class="checkout-btn">Checkout</a>');
     }       
}

function animatedlyAddItemToCart(cartItem,itemSelector,target){
	    var cart = $('.cd-cart-items');
	    target   = $("li[data-index="+target+"]");
	    

        var imgtodrag = $(itemSelector).find('.item-name');
        /* Animatedly move item to Cart*/
        if (imgtodrag) {
	            var imgclone = imgtodrag.clone()
	                .offset({
	                top: imgtodrag.offset().top,
	                left: imgtodrag.offset().left
	            })
	                .css({
	                    'opacity': '1',
	                    'position': 'absolute',
	                    'height': '150px',
	                    'width': '150px',
	                    'z-index': '100'
	            });

		       if(target !== "undefined" && target.length > 0){
		         $(cartItem).insertAfter(target);
		         target.remove();
		         }
		       else
		        {
		        	$(cartItem).appendTo(cart);
		        }  
			   
	            imgclone.animate({
	                    'top': cart.offset().top + 10,
	                    'left': cart.offset().left + 10,
	                    'width': 75,
	                    'height': 75
	            }, 1000, 'easeInOutExpo');
	            
	            setTimeout(function () {
	                cart.effect("shake", {
	                    times: 2
	                }, 200);
	            }, 1500);

	            imgclone.animate({
	                     'width': 0,
	                    'height': 0
	            }, function () {
	                $(this).detach();
	            });
        }
}


jQuery(document).ready(function($){

        var userCart  = new UserCart();
		$cart_trigger = $('.cart-mobile-summary');
		$lateral_cart = $('#cd-cart');
		$shadow_layer = $('#cd-shadow-layer');


	//open cart
	$cart_trigger.on('click', function(event){
		event.preventDefault();
		var returnStatus = toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
		$('#cd-cart .horizontal-loader').removeClass('hidden');
        if(returnStatus == "OPENING_CART"){
		   userCart.showItemInCart();
        }

	});

	//close lateral cart or lateral menu
	$shadow_layer.on('click', function(){
		$shadow_layer.removeClass('is-visible');
		// firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
		if( $lateral_cart.hasClass('speed-in') ) {
			$lateral_cart.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				$('body').removeClass('overflow-hidden');
			});
		} else {
			$lateral_cart.removeClass('speed-in');
		}
	});
	$('.each-category-menu-item').click(function(){
		var productToBeAddedInCart = {
           "productId"    : $(this).find('.item-name').attr('data-product-id'),
           "productTitle" : $(this).find('.item-name').attr('data-product-title'),
           "productPrice" : $(this).find('.item-name').attr('data-product-price')
        };
         userCart.addItemToCart(productToBeAddedInCart,$(this));
	   }
	);

   $('body').on('click','.cd-item-remove',function(event){
   	     event.preventDefault();
         var productId    = $(this).attr('data-product-id');
         $('#cd-cart .horizontal-loader').removeClass('hidden');
         userCart.removeItemFromCart(productId);
     });

    $('body').on('click','.inc-button',function(event){
   	     event.preventDefault();
         var productId    = $(this).parent().attr('data-product-id');
         var productToBeAddedInCart = { "productId"    : productId };
         userCart.incrementItemCountFromCart(productToBeAddedInCart,$(this));
     });

     $('body').on('click','.dec-button',function(event){
   	     event.preventDefault();
         var productId    = $(this).parent().attr('data-product-id');
         var productDetail = { "productId"    : productId };
         var qty =  $(this).siblings('.user-cart-qty').val();
         if(parseInt(qty,10) === 1)
         {
         	 if(confirm("Do you want to remove this item from your order ?")){
         	 	 userCart.removeItemFromCart(productDetail,$(this));
                }
             
         }
         else{
         	userCart.decrementItemCountFromCart(productDetail,$(this));
         } 
     });

    $('body').on('change','.user-cart-qty',function(event){
          var qty =  parseInt($(this).val(),10);
          var productId    = $(this).parent().attr('data-product-id');
          var productDetail = { "productId"    : productId ,"newQty" : qty};
          if(qty === 0){
               if(confirm("Do you want to remove this item from your order ?")){
                  userCart.removeItemFromCart(productDetail,$(this));
              }
          } 
          else if(!qty){ /* pass */} 
          else{
               userCart.updateItemQty(productDetail,$(this));
          }  
    });
   
});

function toggle_panel_visibility ($lateral_panel, $background_layer, $body) {
	if( $lateral_panel.hasClass('speed-in') ) {
		// firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
		$lateral_panel.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$body.removeClass('overflow-hidden');
		});
		$background_layer.removeClass('is-visible');
        return "CLOSING_CART";

	} else {
		$lateral_panel.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$body.addClass('overflow-hidden');
		});
		$background_layer.addClass('is-visible');
        return "OPENING_CART";
	}
}



