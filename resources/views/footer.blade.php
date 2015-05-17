  <div class="col-md-12" id="footer" >
    <div class="bs-docs-section">
      <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2"></div>
        <div class="col-lg-8 col-md-8 col-sm-8 secondary">
          <ul class="center uppercase">
            <li><a href="{{ url('/about-us') }}">About Us</a></li>
            <li><a href="{{ url('/terms-and-conditons') }}">Terms & Conditions</a></li>
            <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
            <li><a href="{{ url('/disclaimer') }}">Disclaimer</a></li>
            <li><a href="{{ url('/contact-us') }}">Contact</a></li>
            <li><a href="{{ url('/complaints') }}">Complaints</a></li>            
          </ul>
          <ul class="p10 center">
           <li><a href="#"><img class="tool" title="Facebook" src="{{ asset('/img/facebook.png') }}" alt=""></a></li>
            <li><a href="#"><img class="tool" title="Twitter" src="{{ asset('/img/twitter.png') }}" alt="" ></a></li>
            <li><a href="#"><img class="tool" title="Google+" src="{{ asset('/img/google.png') }}" alt="" ></a></li>
           </ul>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2"></div>
      </div>
      <!-- End of Secondary Menu -->
      <div class="border"></div>

      <div class="row pt10">
          <div class="col-lg-10 col-md-12 col-sm-12 col-lg-offset-2">
              <div class="col-lg-3 col-md-3 col-sm-3"></div>
              <div class="footer col-lg-4 col-md-6 center">
                <p class="grey" >
                  &copy; 2015 PantryCar.co.in . All rights reserved
                </p>
                  <img src="{{ asset('/img/cod.png') }}" class="img-responsive"><br>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3"></div>
          </div>
      </div>
      </div>  
   </div>  
 

     <!-- Scripts -->
    <script src="{{ asset('/js/jquery-2.1.3.min.js') }} "></script>
    <script src="{{ asset('/js/bootstrap.min.js') }} "></script>
    <script>window.BASE_PATH = "<?php echo url() ;?>"; </script>
    <script src="{{ asset('/js/bootbox.min.js') }}"></script>
     <script src="{{ asset('/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap-datepicker.min.js') }}" ></script>
    <script src="{{ asset('/js/main.js') }}" ></script>
    <script src="{{ asset('/js/nanobar.min.js') }}" ></script>
    <script src="{{ asset('/js/typehead.min.js') }}" ></script>
   

     @if(Session::get('login') === 1)
      <script>
      $(function() {
            bootbox.dialog({
            title: "Login",
            message: $('#loginform').html()
          }).find("div.modal-dialog").css("width","800px");
      });
    </script>
    @endif
   
    <script>


      //running loader at the top
      var nanobar = new Nanobar({"bg":"#e76f62","id":"nano"});
      nanobar.go(100);
 // Let the DOM get ready
 $(document).ready(function(){
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

          /*---------------------------------------
          -----------------------------------------
           Menu Dialog
          -----------------------------------------
          -----------------------------------------
          */

        $(".resMenuDialog").each(function(index){
              $("#res-menu-dialog-"+index).dialog({
                  autoOpen: false,
                  modal:true,
                  dialogClass: "custom-ui-dialog",
                  hide: {
                      effect: "scale",
                      easing: "easeInBack"
                  },
                  show: {
                      effect: "scale",
                      easing: "easeOutBack"
                  },
                  buttons: {
                    Cancel: function(){
                        $( this ).dialog( "close" );
                    }
                }
             });
      });
    
        $(".tag-menu").click(function() {
           var resMenuId = $(this).data("res-menu-id");
           $("#res-menu-dialog-"+resMenuId).dialog("open");
    });

});
</script>
