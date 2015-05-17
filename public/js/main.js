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
                            $(".alert-danger").append('<strong>Whoops!</strong> Wrong Username/Password.<br><br>');
                            $(".alert-danger").removeClass('hidden');
                    } 
                    else {
                         location.reload();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went to wrong.Please Try again later...');
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
                 alert('Something went to wrong.Please Try again later...');
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
     console.log($(this).data("station-code"));
     var $_token = $('input[name=_token]').val();
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action",BASE_PATH + '/selectRestaurant');
     var input = $(document.createElement('input')).attr('name','station_code').val($(this).data("station-code"));
     var tokenInput = $(document.createElement('input')).attr('name','_token').val($_token);
     form.append(input).append(tokenInput);
     $("body").append(form);
     form.submit();

});

/*
-------------------------------------------------------
Each train selection process
-------------------------------------------------------
*/

$('body').on('click','.select-train-button a',function(event){
     event.preventDefault();
     var $_token = $('input[name=_token]').val();
     var tokenInput = $(document.createElement('input')).attr('name','_token').val($_token);
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action",BASE_PATH + '/selectStation');
     form.append(tokenInput);
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

});