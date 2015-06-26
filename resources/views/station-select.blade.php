
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
 	 	@if($station_list !== "")
 	      <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
 	      <div class="head-common-color" ><h4>SELECT STATION</h4></div>
 	      <div class="station-select-header-wrap">
 	      	 <?php $totalRecord = count($station_header);
 	      	 $iterator = 0;
 	      	 ?>
 	      	 @foreach($station_header as $record)
 	      	      @if($iterator == 0)
                    <div class="floatleft station-select-header pr10 pb10 pt10 uppercase" >{{ $record }}</div>
                  @else
                    <div class="floatleft station-select-header p10 uppercase" >{{ $record }}</div>
                  @endif
                  @if($iterator < ($totalRecord - 1))
                    <div class="floatleft fa fa-arrow-right breadcrumb-arrow"></div>
                  @endif  
                  <?php $iterator++; ?>
 	      	  @endforeach	
 	      </div>

		  <div id="station-select-wrap" class="station-select-wrap pagespan head-common-color" >
					@foreach($station_list as $station => $eachStationDetail)
	                  <div class="each-station-wrap">
	                  	   <input type="hidden" name="station_code" value="{{ $station }}" />
                          	<div class="station-header">
                          		{{ $station }}
                          	</div>
				         	    <div class="each-station__inner-block no-border-left">{{ $eachStationDetail['STATION_NAME'] }}</div>
				            	<div class="each-station__inner-block">{{ $eachStationDetail['ARRIVAL_TIME'] }}</div>
				            	<div class="each-station__inner-block">{{ $eachStationDetail['HALT'] }}</div>
				            	<div class="each-station__inner-block">{{ $eachStationDetail['DAY'] }}</div>
				            	<div class="each-station__inner-block select-station-button">
				            		    <a  data-loading-text="GET MY FOOD<i class='fa-refresh fa-spin fa ml10'></i>" href="{{ $eachStationDetail['stationSeoUrl'] }}"  class="pc-btn loading-text-button">
					                        GET MY FOOD
					                    </a>
					            </div>
	                   </div> 
	                @endforeach
		</div>
		@else
		<div class="no-result-grid">
			 <div class="no-result-found">
			 	No station found against given input .Modify your search and try again.
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
