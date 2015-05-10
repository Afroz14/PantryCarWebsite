
<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')
 <link href="{{ asset('/css/owl.carousel.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/owl.default.theme.min.css') }}" rel="stylesheet">
 <div class="full-width-container-other">
 	@if($station_list !== "")
 	 <div class="col-lg-9 col-lg-offset-1">
 	      <input type="hidden" name="_token" id="csrf_token" value="{{ csrf_token() }}">
 	      <div class="page-header head-common-color" ><h4>SELECT STATION</h4></div>
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
                    <div class="floatleft icon-angle-right breadcrumb-arrow"></div>
                  @endif  
                  <?php $iterator++; ?>
 	      	  @endforeach	
 	      </div>
 	    </div>  
 	    <div class="col-lg-9 col-lg-offset-1" >
		  <div id="station-select-wrap" class="station-select-wrap pagespan head-common-color" >
            
			<!--<button class="backward head-common-color"><i class="icon-angle-left"></i></button>
			<button class="forward head-common-color"><i class="icon-angle-right"></i></button>

			<div class="frame" >
				<ul>-->
					
					@foreach($station_list as $station => $eachStationDetail)
	                  <div class="each-station-block">
	                  	<div class="uppercase pl10 textleft" >{{ $station }}</div>
	                  	<div class="uppercase pt10 pb30 pl10 textleft" >{{ $eachStationDetail['STATION_NAME'] }}</div>
	                  	<?php $iterator = 0; ?>
	                    @foreach($eachStationDetail as $record)
	                       @if($iterator > 0)
	                        <div class="station-subdetails"> {{ $record }}</div>
	                      @endif  
	                      <?php $iterator++; ?>
	                    @endforeach  
	                    
	                   </div> 
	                @endforeach
				<!--</ul>
			</div>

			div class="scrollbar">
				<div class="handle">
					<div class="mousearea"></div>
				</div>
			</div>

			<div class="controls">
				<button data-action="toStart"><i class="icon-double-angle-left"></i> Start</button>
				<span class="divider"></span>
				<button class="prev"><i class="icon-angle-left"></i> Prev</button>
				<span class="divider"></span>
				<button class="next">Next <i class="icon-angle-right"></i></button>
				<span class="divider"></span>
				<button data-action="toEnd">End <i class="icon-double-angle-right"></i></button>
			</div>-->
	    </div>		
		</div>
		@else
		<div class="no-result-grid">
			 <div class="no-result-found">
			 	No station found against PNR .Please check your PNR and then try again .
			 </div>	
			 <div class="form-group buttons">
	                    <a href="{{ url('/') }} " class="pc-btn">
	                        GO HOME
	                    </a>
	          </div>
          </div> 
		@endif
</div>

@include('footer')

</body>
</html>
