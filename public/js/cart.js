/*
*  Cart Controller and related events
*/
function UserCart(){};


UserCart.prototype.addItemToCart = function(productToBeAddedInCart) {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/addItemToCart',
            data:{'_token':X_ACCESS_TOKEN,"productDetail":productToBeAddedInCart},
            method:'POST',
            success:function(data){
            	 /* Clear previous cart state */
            	 $('#cart-trigger').find('#label-cart-item-count').remove();
            	 $('#cart-trigger').append(data);
            },
            error:function(){
            }
         });
};

UserCart.prototype.showItemInCart = function() {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/getCart',
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

UserCart.prototype.removeItemFromCart = function(productId,target) {
	   $.ajax({
            cache: false,
            url: BASE_PATH + '/removeItemFromCart',
             data:{'_token':X_ACCESS_TOKEN,"productId":productId},
            method:'POST',
            success:function(data){
            	if(data.status == 'true'){
            		$('#cd-cart #cd-cart-items-wrap').html(data.cartContent);
            		/* Clear previous cart state */
            		$('#cart-trigger').find('#label-cart-item-count').remove();
            		$('#cart-trigger').append(data.cartItemCount);
            	}
            	$('#cd-cart .horizontal-loader').addClass('hidden');
            },
            error:function(){
            	$('#cd-cart .horizontal-loader').addClass('hidden');
            }
         });
};


jQuery(document).ready(function($){

        var userCart  = new UserCart();
		$cart_trigger = $('#cart-trigger'),
		$lateral_cart = $('#cd-cart'),
		$shadow_layer = $('#cd-shadow-layer');


	//open cart
	$cart_trigger.on('click', function(event){
		event.preventDefault();
		toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
		$('#cd-cart .horizontal-loader').removeClass('hidden');
		userCart.showItemInCart();

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
           "productPrice" : $(this).find('.item-name').attr('data-product-price'),
        };
        var cart = $('#cart-trigger');
        var imgtodrag = $(this).find('.item-name');
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
	            })
	                .appendTo($('body'))
	                .animate({
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
	                $(this).detach()
	            });
        }
        // Ajax request to add item onto Cart
        userCart.addItemToCart(productToBeAddedInCart);
	   }
	);

   $('body').on('click','.cd-item-remove',function(event){
   	     event.preventDefault();
         var productId    = $(this).attr('data-product-id');
         $('#cd-cart .horizontal-loader').removeClass('hidden');
         userCart.removeItemFromCart(productId,$(this).parent());
     });
});

function toggle_panel_visibility ($lateral_panel, $background_layer, $body) {
	if( $lateral_panel.hasClass('speed-in') ) {
		// firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
		$lateral_panel.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$body.removeClass('overflow-hidden');
		});
		$background_layer.removeClass('is-visible');

	} else {
		$lateral_panel.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$body.addClass('overflow-hidden');
		});
		$background_layer.addClass('is-visible');
	}
}



