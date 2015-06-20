   <nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header col-md-9">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/')}}">PANTRY<span class="color-orange">CAR</span></a>
			</div>

          <div class="col-md-3 pt15" id="helpline-number">
       	       <i class="glyphicon glyphicon-phone-alt pr10"></i><span class="color-grey">Call Us : <span class="color-orange">+91 - 9911869145</span> </span>
           </div>

		</div>
	</nav>
    <div class="col-md-12 "> 
    				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav navbar-right">
						       @if(Auth::guest())
								<li><a class="pc_login color-grey" href="#">Login</a></li>
								 <li class="nav-divider"></li>
								<li><a class="pc_signup color-grey" href="#">Register</a></li>
								<li class="nav-divider"></li>
							    @else
								<li class="dropdown">
									<a href="#" class="dropdown-toggle color-grey" data-toggle="dropdown" role="button" aria-expanded="false">{{ ucwords(Auth::user()->name) }}<span class="caret ml10"></span></a>
									<ul class="dropdown-menu " role="menu">
										<li class="mini-cart no-border-top color-grey"><a href="{{ url('/profile') }}">{{ Auth::user()->id }}</a></li>
										<li class="mini-cart color-grey"><a href="{{ url('/logout') }}">LOGOUT</a></li>
										<li class="mini-cart color-grey"><a href="{{ url('/profile#orders') }}">MY ORDERS</a></li>
									</ul>
								</li>
								<li class="nav-divider"></li>
								@endif
								<li><a class="color-grey" href="/requestCallback/add">Request A Call Back</a></li>
								<li class="nav-divider"></li>
								<li><a class="color-grey" href="/order/orderStatus">Order Tracker</a></li>
								<li class="nav-divider"></li>
								<li><a class="color-grey" href="/groupTravel/groupTravel">Group Travel</a></li>
								<li class="nav-divider"></li>
								<li><a class="color-grey" href="{{ url('/viewCart') }}" id="cart-trigger" role="button" aria-expanded="false">
									  <i class="icon-shopping-cart color-grey"></i> 
									   Cart
									    @if(Cart::count() > 0)
									      <span id="label-cart-item-count"> {{ Cart::count(false) }} </span>
									   	@endif
									   </a>
								</li>
						</ul>
			   </div>
    </div>
     @include('auth/login')
     @yield('login-content')
     @include('auth/register')
     @yield('register-content')
          
    <!--
	 <div id="loginform" class="login hidden ">
        <h1 class="logo">Login</h1>

        
        <form role="form" method="post" action="/sessions">
            <input name="_token" type="hidden" value="NrRFMryAVxzXyobC6SxovBTQtojIr4n4aIV6ZCU9">

            <div class="form-group">
                <label for="email" class="control-label">Email:</label>
                <input class="form-control" id="email" required="1" name="email" type="email">
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group text-left">
                <input type="checkbox" name="remember" id="remember"> <label for="remember">Remember Me</label>
            </div>

            <div class="form-group buttons">
                <button type="submit" class="btn btn-primary">
                    Sign In
                </button>

                <a href="/password_resets/create" class="text-muted">Forgot Your Password?</a>
            </div>
        </form>
    </div>-->

	


