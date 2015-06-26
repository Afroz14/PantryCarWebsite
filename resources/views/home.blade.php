<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

<div class="full-width-container-home landing-background ">
  @if(null != Session::get('error_message')) 
  <div class="alert alert-info">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <p> {{ Session::get('error_message') }} </p>
  </div>
  @endif
  @if(null != Session::get('success_message')) 
  <div class="alert alert-success">
      <a href="#" class="close" data-dismiss="alert">&times;</a>
      <p> {{ Session::get('success_message') }} </p>
  </div>
  @endif
  <div class="col-lg-4 col-md-8 col-sm-8 col-lg-offset-1 mt20 border-white search-container">
  	<div class="subheading"> BOOK YOUR MEAL ON THE GO </div>
        <div class="home-box-container container-min-width">
            <div class="row">

                        <div class="col-md-6 form-separator pr30">
                            <center>
                                <form role="form" class="home-page-search-form" id= "pnr-search-form" method="get" action="{{ url ('/selectStation') }}">
                                    <!--<input name="_token" type="hidden" value="{{ csrf_token() }}">-->
                                    <input name="search_type" type="hidden" value="pnr_search">

                                    <div class="form-group">
                                        <input class="form-control input-class" id="pnr_number" required="1" name="pnr_number" type="text" placeholder="Enter PNR">
                                    </div>
                                    <div class="pnr-type-ahead">
                                      <div class="horizontal-loader hidden"></div>
                                      <div class="col-md-12" id="pnr-search-result-container">
                                        <div class="right-arrow-icon__pnr_result hidden"></div>
                                        <div id="pnr_result_message_any" class="hidden"></div>
                                         <div id="pnr_date"></div>
                                         <div class="floatleft textleft">
                                                <div id="pnr_train_num"></div>
                                                <div id="pnr_src_station_name"></div>
                                                <div id="pnr_src_station_code"></div>
                                                <div id="pnr_status"></div>
                                         </div>
                                         <div class="floatright textleft">
                                                <div id="pnr_train_name"></div>
                                                <div id="pnr_dest_station_name"></div>
                                                <div id="pnr_dest_station_code"></div>
                                                <div id="pnr_seat"></div>
                                         </div> 
                                      </div> 
                                    </div>

                                    <div class="form-group buttons">
                                        <button type="submit" class="btn btn-search" 
                                          data-loading-text="GET MY FOOD<i class='fa-refresh fa-spin fa ml10'></i>">
                                              <span>GET YOUR FOOD</span>
                                        </button>
                                    </div>
                                </form>
                            </center>
                        </div>
                        
                        <div class="col-md-6 pr30">
                            <center>
                             <form role="form" id= "station-search-form" class="home-page-search-form" method="get" action="{{ url ('/selectTrain') }}">
                                    <!--<input name="_token" type="hidden" value="{{ csrf_token() }}">-->

                                    <div class="form-group">
                                        <input class="form-control input-class" id="source_station" required="1" name="source_station" type="text" placeholder="Enter Source Station">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="destination_station" id="destination_station" class="form-control input-class" required="1" placeholder="Enter Destination Station">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="train_num" id="train_num" class="form-control input-class"  placeholder="Enter Train Name/Code (optional)">
                                    </div>

                                    <div class="form-group">
                                        <div class='input-group date date-time-picker' >
                                            <input type='text' class="form-control" name="journey_date" required="1" placeholder="Enter Journey Date"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="form-group buttons">
                                        <button type="submit" class="btn btn-search" data-loading-text="GET MY FOOD<i class='fa-refresh fa-spin fa ml10'></i>">
                                             GET YOUR FOOD
                                        </button>
                                    </div>
                                </form>
                            </center>
                        </div>
                </div>
        </div>
  </div>
</div>
<!-- How it works section -->
  <section class="col-md-12 how-it-works-grid">
    <div class="col-md-12 how-it-works-wrap">
       <div class="center pc-heading-home pb20">How it works</div>
        <div class="col-md-4 each-how-it-works-block">
          <div class="center">
            <img src="{{ asset ('/img/how_it_works_icon.png') }}" alt="">
          </div>
          <div class="center">
            <h4>Enter PNR/Train Details</h4>
          </div>
        </div>
        <div class="col-md-4 each-how-it-works-block">
          <div class="center">
            <img src="{{ asset ('/img/how_it_works_icon.png') }}" alt="">
          </div>
          <div class="center">
            <h4>Choose your favorite menu</h4>
          </div>
        </div>
        <div class="col-md-4 each-how-it-works-block" >
          <div class="center">
            <img src="{{ asset ('/img/how_it_works_icon.png') }}" alt="">
          </div>
          <div class="center">
            <h4>Pay and enjoy your meal</h4>
          </div>
        </div>
    </div>
</section>     

@include('footer')
<script src="{{ asset('/js/build/autosuggest-inputs.js') }} "></script>

</body>
</html>
