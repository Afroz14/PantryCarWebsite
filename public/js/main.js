
$.PC = {};
//running loader at the top
var nanobar = new Nanobar({"bg":"#e76f62","id":"nano"});
nanobar.go(100);

$.PC.showPNRTypehead = function(){
    $(".pnr-type-ahead").css({"height":"130px",'margin-bottom':"18px"});
    $("#pnr-search-form").css({"height":"150px"});
    this.fetchPNRDetail();
}
$.PC.removePNRTypehead = function(){
  $(".pnr-type-ahead").css({"height":"0px",'margin-bottom':"0px"});
  $("#pnr-search-form").css({"height":"150px"});
}
 
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
            }
         });
}
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
/*
-------------------------------------------------------
  Bootbox popup
-------------------------------------------------------
*/
$('.pc_login').click(function(){
		bootbox.dialog({
		  title: "Login",
		  message: $('#loginform').html(),
           animate: true,
		});
});

$('.pc_signup').click(function(){
        bootbox.dialog({
          title: "Register",
          message: $('#signup-form').html()
        });
});

/*
-------------------------------------------------------
-------------------------------------------------------
*/

$(document).ready(function() {

    $('.date-time-picker').datepicker({
	        autoclose: true,
	        todayBtn: true,
            format:'dd-mm-yyyy'
    });

  $("#pnr_number").on("input",function(){
     if($(this).val().length === 10)
       $.PC.showPNRTypehead();
     else
       $.PC.removePNRTypehead();
  });
/*
-------------------------------------------------------
Signin process
-------------------------------------------------------
*/

    $('body').on('click','#login-button',function(event){

         event.preventDefault();
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
                    if(data.success == false)
                    {
                        var arr = data.errors;
                        $(".alert-danger").html("");
                        $(".alert-danger").append('<strong>Whoops!</strong> There were some problems with your input.<br><br>');
                        $(".alert-danger").append('<ul>');
                        $.each(arr, function(index, value)
                        {
                            if (value.length != 0)
                            {
                                $(".alert-danger").append('<li>'+ value +'</li>');
                            }
                        });
                        $(".alert-danger").append('</ul>');
                        $(".alert-danger").removeClass('hidden');
                    }
                    else if(data.fail == true){
                            $(".alert-danger").append('<strong>Whoops!</strong> Login Failed .Try again<br><br>');
                            $(".alert-danger").removeClass('hidden');
                    } 
                    else {
                         location.reload();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went wrong.Please Try again later...');
            }
         });
    });

/*
-------------------------------------------------------
Signup process
-------------------------------------------------------
*/
    $('body').on('click','#signup-button',function(event){

         event.preventDefault();
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
                            if (value.length != 0)
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
                         location.reload();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went  wrong.Please Try again later...');
            }
         });
    });
/*
-------------------------------------------------------
Each station selection process
-------------------------------------------------------
*/
$('body').on('click','.select-station-button a',function(event){
     event.preventDefault();
     var stationCode  = $(this).data("station-code");
     var newUrl       = window.location.href;
     var seperator    = (url.indexOf("?") === -1)?"?":"&";
     var newUrl       = url + seperator + "station_code="+stationCode;
     newUrl           = newUrl.replace("selectStation","selectRestaurant");
     window.location.href =  newUrl;

});

/*
-------------------------------------------------------
Each train selection process
-------------------------------------------------------
*/

$('body').on('click','.select-train-button a',function(event){
     event.preventDefault();
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","GET").attr("action",BASE_PATH + '/selectStation');
     var input = $(document.createElement('input')).attr('name','train_num').val($(this).data('train-code'));
     form.append(input);
     var input = $(document.createElement('input')).attr('name','source_station').val($(this).data("source-station"));
     form.append(input);
     var input = $(document.createElement('input')).attr('name','destination_station').val($(this).data("destination-station"));
     form.append(input);
     var input = $(document.createElement('input')).attr('name','journey_date').val($(this).data("doj"));
     form.append(input);
     var input = $(document.createElement('input')).attr('name','search_type').val("train_search");
     form.append(input);
     $("body").append(form);
     form.submit();
});

  
      
    // Javascript to enable link to tab
      var url = document.location.toString();
      if (url.match('#')) {
          $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show');
      } 

      // Change hash for page-reload
      $('body').on('shown.bs.tab','.nav-tabs a', function (e) {
          window.location.hash = e.target.hash;
      });

        
    

}); // DOM Ready close