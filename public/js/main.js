
/* --------------------
 * - PantryCar 
 * --------------------
 */

$.PC = {};

$.PC.options = {
 
 screenSizes: {
    xs: 480,
    sm: 768,
    md: 992,
    lg: 1200
  }
};  

$.PC.showPNRTypehead = function(fetchPnr){
    $(".pnr-type-ahead").css({"height":"130px",'margin-bottom':"16px"});
    if(fetchPnr === true){
       this.fetchPNRDetail();
    }
    else{
        $('.pnr-type-ahead').css({'box-shadow': '0 0 30px #2AB3DB'});
    }
};
$.PC.removePNRTypehead = function(){
  $(".pnr-type-ahead").css({"height":"0px",'margin-bottom':"0px"});
};

$.PC.handleRedirectAfterLoginOrSignup = function(){
      if ($(".bootbox-body input[name=redirect_url]").length > 0 ){
                if($(".bootbox-body input[name=redirect_method]").val() === 'GET'){
                                 window.location = $(".bootbox-body input[name=redirect_url]").val();
                }
                else if($(".bootbox-body input[name=redirect_method]").val() === 'POST'){
                                  $("#"+$(".bootbox-body input[name=redirect_controller]").val()).submit();
                } 
      }
      else{
          window.location.reload();
      }
};

$.PC.fetchPNRDetail = function(){
       var pnrNumber = $("#pnr_number").val();
        $.ajax({
            cache: false,
            dataType: 'json',
            url: BASE_PATH + '/getPnrDetail/'+ pnrNumber ,
            method:'GET',
            beforeSend: function() { 
                 $(".pnr-type-ahead .horizontal-loader").removeClass("hidden");
                 $("#pnr-search-result-container #pnr_result_message_any").html(""); 
                 $("#pnr-search-result-container #pnr_result_message_any").addClass("hidden");
                 $("#pnr-search-result-container .right-arrow-icon__pnr_result").addClass("hidden");
            },
            success:function(data){
                  $(".pnr-type-ahead .horizontal-loader").addClass("hidden");
                    if(data && data.status){
                        if(data.status === true)
                          {
                             $("#pnr-search-result-container #pnr_date").html(data.doj);
                             $("#pnr-search-result-container #pnr_train_num").html(data.trainNum);
                             $("#pnr-search-result-container #pnr_src_station_name").html(data.srcStationName);
                             $("#pnr-search-result-container #pnr_src_station_code").html(data.srcStationCode);
                             $("#pnr-search-result-container #pnr_status").html("Confirmed");
                             $("#pnr-search-result-container #pnr_train_name").html(data.trainName);
                             $("#pnr-search-result-container #pnr_dest_station_name").html(data.destStationName);
                             $("#pnr-search-result-container #pnr_dest_station_code").html(data.destStationCode);
                             $("#pnr-search-result-container #pnr_seat").html("B2 45");
                             $("#pnr-search-result-container .right-arrow-icon__pnr_result").removeClass("hidden");
                         }
                        else{
                              $.PC.clearPnrResultWithThisMessage("PNR not found !");
                          } 
                    }   
                    else {
                             $.PC.clearPnrResultWithThisMessage("PNR not found !");    
                    } 
            },
            error:function(){
                $(".pnr-type-ahead .horizontal-loader").addClass("hidden");
                $.PC.clearPnrResultWithThisMessage("Oops ! some server error occured");  
            }
         });
};
$.PC.clearPnrResultWithThisMessage = function(message){

                 $("#pnr-search-result-container #pnr_date").html("");
                 $("#pnr-search-result-container #pnr_train_num").html("");
                 $("#pnr-search-result-container #pnr_src_station_name").html("");
                 $("#pnr-search-result-container #pnr_src_station_code").html("");
                 $("#pnr-search-result-container #pnr_status").html("");
                 $("#pnr-search-result-container #pnr_train_name").html("");
                 $("#pnr-search-result-container #pnr_dest_station_name").html("");
                 $("#pnr-search-result-container #pnr_dest_station_code").html("");
                 $("#pnr-search-result-container #pnr_seat").html("");
                 $("#pnr-search-result-container #pnr_result_message_any").html(message);   
                 $("#pnr-search-result-container #pnr_result_message_any").removeClass("hidden");
                 $("#pnr-search-result-container .right-arrow-icon__pnr_result").addClass("hidden");
};

$.PC.verifyAndSubmitPNR = function(button){
        var pnrNumber = $("#pnr_number").val();
        $.ajax({
            cache: false,
            dataType: 'json',
            url: BASE_PATH + '/getPnrDetail/'+ pnrNumber ,
            method:'GET',
            beforeSend: function() { 
                 $(button).button('loading'); 
            },
            success:function(data){
                  //$(".pnr-type-ahead .horizontal-loader").addClass("hidden");
                 $(button).button('reset'); 
                    if(data && data.status){
                        if(data.status === true)
                          {
                            $('#pnr-search-form').submit();
                         }
                        else{
                              $.PC.showPNRTypehead(false);
                              $.PC.clearPnrResultWithThisMessage("PNR not found !");
                          } 
                    }   
                    else {
                             $.PC.showPNRTypehead(false);
                             $.PC.clearPnrResultWithThisMessage("PNR not found !");    
                    } 
            },
            error:function(){
                //$(".pnr-type-ahead .horizontal-loader").addClass("hidden");
                $.PC.showPNRTypehead(false);
                $.PC.clearPnrResultWithThisMessage("Oops ! some server error occured");  
                $(button).button('reset'); 
            }
         });
};


$.PC.showSigninTab = function(){
     $(".alert-danger").addClass('hidden').empty(); 
     $('.form-signin-email-passwd').removeClass('hidden');
     $('.login-links').removeClass('hidden');
     $('.form-signup-email-passwd').addClass('hidden');
     $('.signup-links').addClass('hidden');
     $('.bootbox .modal-header .modal-title').html('Login');
};
$.PC.showSignupTab = function(){
     $(".alert-danger").addClass('hidden').empty(); 
     $('.form-signup-email-passwd').removeClass('hidden');
     $('.signup-links').removeClass('hidden');
     $('.form-signin-email-passwd').addClass('hidden');
     $('.login-links').addClass('hidden');
     $('.bootbox .modal-header .modal-title').html('Signup');
};
$.PC.formLogin = function(){
         $('.bootbox-body .ajax_loader__wrapper').removeClass('hidden');
         $.ajax({
            cache: false,
            dataType: 'json',
            url: BASE_PATH + '/login',
            method:'POST',
            data:$('.bootbox-body .form-signin-email-passwd').serialize(),
            beforeSend: function() { 
                    $(".alert-danger").addClass('hidden').empty(); 
            },
            success:function(data){
                    $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                    if(data.success === false)
                    {
                        var arr = data.errors;
                        $(".alert-danger").html("");
                        $(".alert-danger").append('<strong>Whoops!</strong> There were some problems with your input.<br><br>');
                        $(".alert-danger").append('<ul>');
                        $.each(arr, function(index, value)
                        {
                            if (value.length !== 0)
                            {
                                $(".alert-danger").append('<li>'+ value +'</li>');
                            }
                        });
                        $(".alert-danger").append('</ul>');
                        $(".alert-danger").removeClass('hidden');
                    }
                    else if(data.fail === true){
                            $(".alert-danger").append('<strong>Whoops!</strong> Login Failed .Try again<br><br>');
                            $(".alert-danger").removeClass('hidden');
                    } 
                    else {
                           $.PC.handleRedirectAfterLoginOrSignup();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went wrong.Please Try again later...');
            }
         });
};

$.PC.formSignup = function(){
        $('.bootbox-body .ajax_loader__wrapper').removeClass('hidden');
         $.ajax({
            cache: false,
            dataType: 'json',
            url: BASE_PATH + '/signup',
            method:'POST',
            data:$('.bootbox-body .form-signup-email-passwd').serialize(),
            beforeSend: function() { 
                    $(".alert-danger").addClass('hidden').empty(); 
            },
            success:function(data){
                    $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                    if(data.success === false)
                    {
                        var arr = data.errors;
                        $(".alert-danger").html("");
                        $(".alert-danger").append('<strong>Whoops!</strong> There were some problems with your input.<br><br>');
                        $(".alert-danger").append('<ul>');
                        $.each(arr, function(index, value)
                        {
                            if (value.length !== 0)
                            {
                                $(".alert-danger").append('<li>'+ value +'</li>');
                            }
                        });
                        $(".alert-danger").append('</ul>');
                        $(".alert-danger").removeClass('hidden');
                    }
                    else if(data.fail === true){
                         alert('Error while registering your account .Try again or contact support');
                    } 
                    else {
                          $.PC.handleRedirectAfterLoginOrSignup();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went  wrong.Please Try again later...');
            }
         });
};


/*
-------------------------------------------------------
  Bootbox popup
-------------------------------------------------------
*/
$('.pc_login').click(function(){
		bootbox.dialog({
		  title: "Login",
		  message: $('#pc-signin-signup-form').html(),
          animate: true,
          onEscape: function() {
            $.PC.showSigninTab();
          }  
		});

});


/*
-------------------------------------------------------
* On DOM ready events
-------------------------------------------------------
*/

$(document).ready(function() {

    var nowDate = new Date();
    var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
    $('.date-time-picker').datepicker({
	        autoclose: true,
	        todayBtn: true,
            format:'dd-mm-yyyy',
            startDate:today
    });

  $("#pnr_number").on("input",function(){
     if($(this).val().length === 10){
       $.PC.showPNRTypehead(true);
     }
     else{
       $.PC.removePNRTypehead();
     }
  });


/*
-------------------------------------------------------
Signin process
-------------------------------------------------------
*/

    $('body').on('click','#login-button',function(event){
         event.preventDefault();
         $.PC.formLogin();

    });

/*
-------------------------------------------------------
Signup process
-------------------------------------------------------
*/
    $('body').on('click','#signup-button',function(event){
         event.preventDefault();
         $.PC.formSignup();
    });
/*
-------------------------------------------------------
Each train selection process
-------------------------------------------------------
*/

$('body').on('click','.select-train-button a',function(event){
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","GET").attr("action",BASE_PATH + '/selectStation');
     var input = $(document.createElement('input')).attr('name','train_num').val($(this).data('train-code'));
     form.append(input);
     input = $(document.createElement('input')).attr('name','source_station').val($(this).data("source-station"));
     form.append(input);
     input = $(document.createElement('input')).attr('name','destination_station').val($(this).data("destination-station"));
     form.append(input);
     input = $(document.createElement('input')).attr('name','journey_date').val($(this).data("doj"));
     form.append(input);
     input = $(document.createElement('input')).attr('name','search_type').val("train_search");
     form.append(input);
     $("body").append(form);
     form.submit();
});

  $('body').on('click','#loadSignin',function(event){
     event.preventDefault();
     $.PC.showSigninTab();
  });

 $('body').on('click','#loadSignup',function(event){
     event.preventDefault();
     $.PC.showSignupTab();
  });

  $('body').on('click','#proceed-to-pay',function(event){
           event.preventDefault();
           window.location.href = BASE_PATH + "/processPayment";
  });



/* // Javascript to enable link to tabb
  var url = document.location.toString();
  if (url.match('#')) {
          $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
      } 

      // Change hash for page-reload
  $('body').on('shown.bs.tab','.nav-tabs a', function (e) {
          window.location.hash = e.target.hash;
      });/*

/* --------------------
 * - button loading text on click implementation
 * --------------------
 */
$('form').on('submit',function(){
    if($(this).find('button[data-loading-text]').length > 0){
         $(this).find('button[data-loading-text]').button('loading'); 
    }
});

$('.loading-text-button').on('click',function(){
   $(this).button('loading'); 
});


$('#pnr-form-submit').on('click',function(event){
   event.preventDefault();
   $('.pnr-type-ahead').css({'box-shadow': 'none'});
   $.PC.verifyAndSubmitPNR($(this));

});

$('body').on('click','.res-category .all a',function(event){
   event.preventDefault();
   $(".res-category li ").removeClass("active");
   eClass("active");
   $(this).parent().addClass("active");
   $('#res-menu-item-container .each-menu-category-wrap').addClass('active');

});
$('body').on('click','#station-search-button',function(event){

    var _this =  $(this);
    if($("#station-search-form")[0]. checkValidity() === true){

            var srcStationCode  = $("#station-search-form #source_station").val();
            var destStationCode = $("#station-search-form #destination_station").val();
            var journeyDate     = $("#station-search-form #journey_date").val();
             $.ajax({
                    cache: false,
                    url: BASE_PATH + '/selectTrain',
                    method:'GET',
                    data:{'_token':X_ACCESS_TOKEN,"source_station":srcStationCode,"destination_station":destStationCode,"journey_date":journeyDate},
                    success:function(data){
                      (_this).button('reset');
                      $("#select-train-container").html(data);
                            var box = bootbox.dialog({
                                  title: "Select Train",
                                  message: $('#select-train-container').html(),
                                  animate: true,
                                  onEscape: function() {
                                    $('#select-train-container').html("");
                                  }  
                            });
                            var marginTop =  box.height()/2;
                            box.css({
                                  'top': '50%',
                                  'margin-top': function () {
                                    return -(marginTop);
                                  }
                                });
                    },
                    error:function(){
                        (_this).button('reset');
                    }
                 });
   }

});

$('#station-search-form').submit(function(event){
    event.preventDefault();
});

$('#view-hide-order-summary').click(function () {
    if($('#view-hide-order-summary span').hasClass('glyphicon-chevron-down'))
    {
        $('#view-hide-order-summary').html("Hide Order Details <span class='glyphicon glyphicon-chevron-up'></span>");
    }
    else
    {  
        $('#view-hide-order-summary').html("View Order Details <span class='glyphicon glyphicon-chevron-down'></span>");
    }
});

if($('#view-hide-order-summary-container').is(":visible")){
    $("#cart-summary-container").addClass('collapse');
}

/* Animation starts for how it work section */
function isElementInViewport(elem) {
    var $elem = $(elem);
    // Get the scroll position of the page.
    var scrollElem = ((navigator.userAgent.toLowerCase().indexOf('webkit') != -1) ? 'body' : 'html');
    var viewportTop = $(scrollElem).scrollTop();
    var viewportBottom = viewportTop + $(window).height();
    // Get the position of the element on the page.
    var elemTop = Math.round( $elem.offset().top );
    var elemBottom = elemTop + $elem.height();
    return ((elemTop < viewportBottom) && (elemBottom > viewportTop));
}

// Check if it's time to start the animation.
function checkAnimation() {
    var $elem = $('.each-how-it-works-block');
    if(!$elem.length) {return; }
    // If the animation has already been started
    if ($elem.hasClass('animated')) { return; }
    if (isElementInViewport($elem)) {
        // Start the animation
        $elem.addClass('animated fadeInUp');
    }
}

// Capture scroll events
$(window).scroll(function(){
    if( $(window).width() > $.PC.options.screenSizes.xs ){
       checkAnimation();
   }
});
/* Animation ends */

}); //DOM Ends
