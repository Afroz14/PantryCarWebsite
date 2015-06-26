<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

    <div class="container full-width-container-other">
        <section style="padding-bottom: 50px;">
            <div class="col-md-offset-1 col-md-10">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<h3 class="head-common-color">Inside Your cart</h3>
									 <div class="user-cart full-width-cart">
								          {!! $cartContent !!}
							 	      </div>
					</div>
				  </div>
				</div>  
			 </div>
		</section>	 
     </div>

@include('footer')
<script src="{{ asset('/js/build/cart.min.js') }} "></script>
</body>
</html>   			

