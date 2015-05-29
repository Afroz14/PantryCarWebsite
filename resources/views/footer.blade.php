  <div class="col-md-12" id="footer" >
    <div class="bs-docs-section">
      <div class="row">
        <div class="col-md-12 secondary">
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
                  &copy; 2015 pantrycar.co.in . All rights reserved
                </p>
                  <img src="{{ asset('/img/cod.png') }}" class="img-responsive"><br>
              </div>
              <div class="col-lg-3 col-md-3 col-sm-3"></div>
          </div>
      </div>
      </div>  
   </div>  
 

     <!-- Scripts -->
     <script>window.BASE_PATH = "<?php echo url() ;?>"; </script>
     <script src="{{ asset('/js/build/app.min.js') }} "></script>
     @if(Session::get('login') === 1)
      <script>
      $(function() {
            bootbox.dialog({
            title: "Login",
            message: $('#loginform').html()
          });
      });
    </script>
    @endif