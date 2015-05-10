
<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')
 <link href="{{ asset('/css/owl.carousel.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/owl.default.theme.min.css') }}" rel="stylesheet">
 <div class="full-width-container-other">
 	@if($train_list !== "")
 	 <div class="col-lg-9 col-lg-offset-1">
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
 	    </div> 
 	    <div class="col-lg-9 col-lg-offset-1" >
		  <div id="station-select-wrap" class="station-select-wrap pagespan head-common-color" >
            
			<!--<button class="backward head-common-color"><i class="icon-angle-left"></i></button>
			<button class="forward head-common-color"><i class="icon-angle-right"></i></button>-->

			<!--<div class="frame" >
				<div>-->
					
					@foreach($train_list as $train => $eachTrainDetail)
	                  <div class="each-train-block">
	                  	<input type="hidden" name="train_code" value = "{{ $train }}">
	                  	<input type="hidden" name="source_station" value = "{{ $train_list_header['SRC_STATION'] }}">
	                  	<input type="hidden" name="destination_station" value = "{{ $train_list_header['DESTINATION_STATION'] }}">
	                  	<input type="hidden" name="doj" value = "{{ $train_list_header['DATE'] }}">
	                  	<div class="uppercase pt10 pb10 pl10 textleft">{{ $train }}</div>
	                  	<div class="uppercase pt10 pb30 pl10 textleft">{{ $eachTrainDetail['TRAIN_NAME'] }}</div>
	                  	<?php $iterator = 0; ?>
	                    @foreach($eachTrainDetail as $record)
	                       @if($iterator > 0)
	                         <div class="train-subdetails"> {{ $record }}</div>
	                       @endif  
	                       <?php $iterator++; ?>
	                    @endforeach  
	                    
	                   </div> 
	                @endforeach
			<!--	</div>
			</div>-->

			<!--<div class="scrollbar">
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

@include('footer')

</body>
</html>
