<!DOCTYPE html>
<html lang="en">
@include('meta')
<body>
@include('header')

<div class="about-us-header bottom-line-wrap ">
    <h3>About us</h3>
    <div class="bottom-line"></div>
</div>

 <div class="col-md-12 col-md-offset-3 mt20">
    <h4 class="col-md-6 text-center">
      PantryCar lets railway traveller to book meal from their favorite restaurants nearby their journey stations .
      We are working hard to cover more and more stations.
      </h4>
 </div>
 <div class="col-md-12 mt20 clear about-us-wrap">
    <div class="col-md-6 about-us-user-section">
        <h3 class="text-center">Welcome to our community</h3>
    </div>
    <div class="col-md-6 about-us-section">
       <ul class="about-us-description">
         <li><i class="fa fa-check pr10"></i>Easy Ordering</li>
         <li><i class="fa fa-check pr10"></i>More choices</li>
         <li><i class="fa fa-check pr10"></i>Rewards Points</li>
       </ul>
    </div>
</div>
  <div class="col-md-12 mb20 about-us-wrap">
          <div class="col-md-6 about-us-merchant-section col-md-push-6">
            <h3 class="text-center">Join our merchant network</h3>
          </div>
          <div class="col-md-6 about-us-section col-md-pull-6">
            <ul class="about-us-description">
               <li><i class="fa fa-check pr10"></i>Online Ordering</li>
               <li><i class="fa fa-check pr10"></i>More Customers</li>
               <li><i class="fa fa-check pr10"></i>Better Business</li>
             </ul>
          </div>
  </div>
<div class="col-md-12 text-center bottom-line-wrap ">
    <h3>We are currently serving at these locations</h3>
    <div class="bottom-line"></div>
    <img src="{{  asset('/img/svg/india-map-location.svg') }}" class="svg-map">
</div>

<div class="col-md-4 col-md-offset-4 pc-rectangle-block mb20 text-center p20">
        <h3><strong>Haven't found out your station ?</strong></h3>
        <h5 class="mb20">Use PantryCar feedback to get things working out .</h5>
        <a href="{{ url('/contact-us') }}" class="pc-btn">
              Write to us
            </a>
</div>
 
@include('footer')
</body>
</html>
