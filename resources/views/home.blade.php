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
  <div class="col-lg-4 col-md-8 col-sm-8 col-lg-offset-1 mt20 border-white search-container">
  	<div class="subheading"> BOOK YOUR MEAL ON THE GO </div>
        <div class="container container-min-width">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-8 col-xs-9 bhoechie-tab-container">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                      <div class="list-group">
                        <a href="#" class="list-group-item text-center no-border-left pt28 pb28 active">
                          Order by PNR
                        </a>
                        <a href="#" class="list-group-item text-center no-border-left pt20 pb20">
                          Order by Location
                        </a>
                        <a href="#" class="list-group-item text-center no-border-left no-border-radius pt20 pb20">
                          Order by Train Name
                        </a>
                      </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-8 bhoechie-tab">

                        <div class="bhoechie-tab-content active">
                            <center>
                                <form role="form" id= "search-form" method="post" action="{{ url ('/selectStation') }}">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                    <input name="search_type" type="hidden" value="pnr_search">

                                    <div class="form-group">
                                        <input class="form-control input-class" id="pnr_number" required="1" name="pnr_number" type="text" placeholder="Enter PNR">
                                    </div>

                                    <div class="form-group buttons">
                                        <button type="submit" class="btn btn-search">
                                            GET YOUR FOOD
                                        </button>
                                    </div>
                                </form>
                            </center>
                        </div>
            
                        
                        <div class="bhoechie-tab-content">
                            <center>
                             <form role="form" id= "search-form" method="post" action="{{ url ('/selectTrain') }}">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input class="form-control input-class" id="source_station" required="1" name="source_station" type="text" placeholder="Enter Source Station">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="destination_station" id="destination_station" class="form-control input-class" required placeholder="Enter Destination Station">
                                    </div>

                                    <div class="form-group">
                                        <div class='input-group date date-time-picker' >
                                            <input type='text' class="form-control" name="journey_date" placeholder="Enter Journey Date"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="form-group buttons">
                                        <button type="submit" class="btn btn-search">
                                             GET YOUR FOOD
                                        </button>
                                    </div>
                                </form>
                            </center>
                        </div>
                        <div class="bhoechie-tab-content">
                            <center>
                            <form role="form" id= "search-form" method="post" action="">
                                    <input name="_token" type="hidden" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input class="form-control input-class" id="train_name_number" required="1" name="train_name_number" type="text" placeholder="Enter Train Name">
                                    </div>

                                    <div class="form-group">
                                        <div class='input-group date date-time-picker' >
                                            <input type='text' class="form-control" placeholder="Enter Journey Date"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div> 

                                    <div class="form-group buttons">
                                        <button type="submit" class="btn btn-search">
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
  </div>
</div>

@extends('footer')

</body>
</html>
