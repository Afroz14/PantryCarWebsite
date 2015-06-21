
<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')
 <link href="{{ asset('/css/owl.carousel.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/owl.default.theme.min.css') }}" rel="stylesheet">
 <div class="full-width-container-other">
 	 <div class="col-lg-10 col-lg-offset-1">
 	 	{!! $breadcrumb !!}
 	 	@if($train_list !== "")
 	      <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
 	      <div class="page-header head-common-color" ><h4>SELECT TRAIN</h4></div>
 	      <div class="station-select-header-wrap">
 	      	 <?php $totalRecord = count($train_list_header);
 	      	 $iterator = 0;
 	      	 ?>
 	      	 @foreach($train_list_header as $record)
 	      	      @if($iterator == 0)
                    <div class="floatleft station-select-header pr10 pb10 pt10 uppercase" >{{ $record }}</div>
                  @else
                    <div class="floatleft station-select-header p10 uppercase" >{{ $record }}</div>
                  @endif
                  @if($iterator < ($totalRecord - 1))
                    <div class="floatleft icon-angle-right breadcrumb-arrow"></div>
                  @endif  
                  <?php $iterator++; ?>
 	      	  @endforeach	
 	      </div>
		  <div id="station-select-wrap" class="station-select-wrap pagespan head-common-color" >
            					
					@foreach($train_list as $train => $eachTrainDetail)
	                  <div class="each-train-wrap">
                          	<div class="train-header">
                          		{{ $train }} {{ $eachTrainDetail['TRAIN_NAME'] }}
                          	</div>
				         	    <div class="each-train__inner-block no-border-left">{{ $eachTrainDetail['ARRIVAL_TIME_AT_SOURCE'] }}</div>
				            	<div class="each-train__inner-block">{{ $eachTrainDetail['DEPARTURE_TIME_AT_SOURCE'] }}</div>
				            	<div class="each-train__inner-block">{{ $eachTrainDetail['ARRIVAL_TIME_AT_DESTINATION'] }}</div>
				            	<div class="each-train__inner-block">{{ $eachTrainDetail['DEPARTURE_TIME_AT_DESTINATION'] }}</div>
				            	<div class="each-train__inner-block select-train-button">
				            		 <a data-train-code = "{{ $train }}" data-source-station = "{{ $train_list_header['SRC_STATION'] }}" data-destination-station = "{{ $train_list_header['DESTINATION_STATION'] }}" data-doj ="{{ $train_list_header['DATE'] }}"  href="#" class="pc-btn">
					                        GET MY FOOD
					                  </a>
					            </div>
	                   </div> 
	                @endforeach
		</div>
		@else
		<div class="no-result-grid">
			 <div class="no-result-found">
			 	No Train found against your inputs .Please check and then try again .
			 </div>	
			 <div class="form-group buttons">
	                    <a href="{{ url('/') }} " class="pc-btn">
	                        GO HOME
	                    </a>
	          </div>
          </div> 
		@endif
   </div>		
</div>

@include('footer')

</body>
</html>
