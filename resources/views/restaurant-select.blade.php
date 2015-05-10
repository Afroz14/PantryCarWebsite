
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
         <?php $iterator = 0; ?>
	 	      @foreach($restaurantsList as $restaurant)
            <div class="restaurant-section">
	 	      		<div class="restaurant-wrapper ">
                <div class="res-content">
	 	      			  <div class="tag-restaurant" >
                     {{ $restaurant['RestaurantName'] }}
                  </div>
                  <div class="tag-menu" data-res-menu-id="<?php echo $iterator;?>">MENU</div>
                </div>
	 	      		</div>
	 	        </div>	
            <div class="resMenuDialog omit pl10" id="res-menu-dialog-<?php echo $iterator ; ?>" >
                 <div class="page-header head-common-color ui-dialog-header">Menu for {{ $restaurant['RestaurantName'] }}</div>
                 <div></div>
            </div>
            <?php $iterator++ ?>
 	      	  @endforeach
 	       </div> 	
      </div>
</div>


@include('footer')

</body>
</html>
