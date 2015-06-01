
<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

 <div class="full-width-container-other" >
          <div class="container-grid">
 	      <div class="page-header head-common-color">SELECT RESTAURANT</div>
 	      <div class="station-select-header-wrap">
 	      	<?php $totalRecord = count($restaurant_header);
 	      	 $iterator = 0;
 	      	 ?>
 	      	 @foreach($restaurant_header as $record)
 	      	  	  @if($iterator == 0)
                    <div class="floatleft station-select-header pr10 pb10 pt10" >{{ $record }}</div>
                  @else
                    <div class="floatleft station-select-header p10" >{{ $record }}</div>
                  @endif
                  @if($iterator < ($totalRecord - 1))
                    <div class="floatleft icon-angle-right breadcrumb-arrow"></div>
                  @endif  
                  <?php $iterator++; ?>
 	      	  @endforeach	
 	      </div>
 	      
	 	   <div class="restaurant-selection-grid">
	 	      @foreach($restaurantsList as $restaurant)
            <div class="restaurant-section">
	 	      		<div class="restaurant-wrapper ">
                <div class="res-content">
	 	      			  <div class="tag-restaurant" >
                     {{ $restaurant['RestaurantName'] }}
                  </div>
                  <div class="tag-menu"><a href="{{ url('/restaurant/RST1') }}">MENU</a></div>
                </div>
	 	      		</div>
	 	        </div>
 	      	  @endforeach
 	       </div> 	
      </div>
</div>


@include('footer')

</body>
</html>
