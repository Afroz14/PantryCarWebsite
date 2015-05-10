
$('.pc_login').click(function(){
		bootbox.dialog({
		  title: "Login",
		  message: $('#loginform').html(),
           animate: true,
		}).find("div.modal-dialog").css("width","800px");
});

$('.pc_signup').click(function(){
        bootbox.dialog({
          title: "Register",
          message: $('#signup-form').html()
        }).find("div.modal-dialog").css("width","800px");
});



$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        $(this).css("border-right","1px solid #ddd");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });

    $('.date-time-picker').datepicker({
	        autoclose: true,
	        todayBtn: true,
            format:'dd-mm-yyyy'
    });

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
                    } else {
                         location.reload();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went to wrong.Please Try again later...');
            }
         });
    });


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
                    } else {
                         location.reload();
                    }
            },
            error:function(){
                 $('.bootbox-body .ajax_loader__wrapper').addClass('hidden');
                 alert('Something went to wrong.Please Try again later...');
            }
         });
    });
$('body').on('click','.each-station-block',function(event){
     event.preventDefault();
     var $_token = $('input[name=_token]').val();
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action",BASE_PATH + '/selectRestaurant');
     var input = $(document.createElement('input')).attr('name','stationCodeSelected').val("100256");
     var tokenInput = $(document.createElement('input')).attr('name','_token').val($_token);
     form.append(input).append(tokenInput);
     $("body").append(form);
     form.submit();

});

$('body').on('click','.each-train-block',function(event){
     event.preventDefault();
     var $_token = $('input[name=_token]').val();
     var tokenInput = $(document.createElement('input')).attr('name','_token').val($_token);
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","POST").attr("action",BASE_PATH + '/selectStation');
     form.append(input).append(tokenInput);
     var input = $(document.createElement('input')).attr('name','train_num').val($(this).find("input[name='train_code']").val());
     form.append(input).append(input);
     var input = $(document.createElement('input')).attr('name','source_station').val($(this).find("input[name='source_station']").val());
     form.append(input).append(input);
     var input = $(document.createElement('input')).attr('name','destination_station').val($(this).find("input[name='destination_station']").val());
     form.append(input).append(input);
     var input = $(document.createElement('input')).attr('name','journey_date').val($(this).find("input[name='doj']").val());
     form.append(input).append(input);
     var input = $(document.createElement('input')).attr('name','search_type').val("train_search");
     form.append(input).append(input);
     $("body").append(form);
     form.submit();
});

});