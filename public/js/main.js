
//running loader at the top
var nanobar = new Nanobar({"bg":"#e76f62","id":"nano"});
nanobar.go(100);
 
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
     //var $_token = $('input[name=_token]').val();
     //var tokenInput = $(document.createElement('input')).attr('name','_token').val($_token);
     var form  = $(document.createElement('form')).css({display:'none'}).attr("method","GET").attr("action",BASE_PATH + '/selectStation');
     //form.append(tokenInput);
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

        
          /*---------------------------------------
          -----------------------------------------
           Train suggestion
          -----------------------------------------
          -----------------------------------------
          */
          var substringMatcher = function(strs) {
          return function findMatches(q, cb) {
            var matches, substringRegex;
         
            // an array that will be populated with substring matches
            matches = [];
         
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');
         
            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
              if (substrRegex.test(str)) {
                matches.push(str);
              }
            });
         
            cb(matches);
          };
        };
         

     /* var trainSearcher = new Bloodhound({ 
              datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
              queryTokenizer: Bloodhound.tokenizers.whitespace,
              remote: {
                url: window.BASE_PATH +'/getTrainSuggestion/1255',
                ajax: {
                  type: "GET",
                  dataType: "json",
                  success: function (data) {
                      console.log("Got data successfully");
                      console.log(data.resultSet);
                  }
              }
           }
     });*/

    var trainSearcher = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        url: window.BASE_PATH +'/getTrainSuggestion/1255',
        filter: function (movies) {
            // Map the remote source JSON array to a JavaScript object array

            return $.map(movies.value, function (movie) {
              //var term = "haha";
                // m = movie.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)(" + term.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1") + ")(?![^<>]*>)(?![^&;]+;)", "gi"), "<strong>$1</strong>");
//console.log(m);
                return {
                    value: movie
                };
            });
        }
    }
});

    /* var trainSearcher = new Bloodhound({
    datumTokenizer: function(d) { return Bloodhound.tokenizers.whitespace(d.value); },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    limit: 10,
  prefetch: window.BASE_PATH +'/getTrainSuggestion/1255',


  });*/
      
      trainSearcher.initialize(); 

      $('#pnr_number').typeahead({
          hint: true,
          highlight: true,
          minLength: 1
        },
        {
          name: 'states',
          displayKey: 'value',
          source: trainSearcher.ttAdapter()
        });

        $('.typeahead.input-sm').siblings('input.tt-hint').addClass('hint-small');
        $('.typeahead.input-lg').siblings('input.tt-hint').addClass('hint-large');

}); // DOM Ready close