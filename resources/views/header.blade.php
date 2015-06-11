   <nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/')}}">PANTRY<span style="color: #FF6C60;">CAR</span></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  
              <!--<ul class="nav navbar-nav" id="yw0">
					<li class="active"><a class="first" href="">Home</a></li>
					<li><a href="/requestCallback/add">Request A Call Back</a></li>
					<li><a href="/order/orderStatus">Order Tracker</a></li>
					<li><a href="/groupTravel/groupTravel">Group Travel</a></li>
              </ul>-->

				<ul class="nav navbar-nav navbar-right">
				       @if(Auth::guest())
						<li><a class="pc_login" href="#">Login</a></li>
						<li><a class="pc_signup" href="#">Register</a></li>
						<li><a href="{{ url('/viewCart') }}" id="cart-trigger" role="button" aria-expanded="false">
							  <i class="icon-shopping-cart"></i> 
							   Cart
							    @if(Cart::count() > 0)
							      <span id="label-cart-item-count"> {{ Cart::count(false) }} </span>
							   	@endif
							   </a>
						</li>
					    @else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ ucwords(Auth::user()->name) }}<span class="caret ml10"></span></a>
							<ul class="dropdown-menu " role="menu">
								<li class="mini-cart no-border-top"><a href="{{ url('/profile') }}">{{ Auth::user()->id }}</a></li>
								<li class="mini-cart"><a href="{{ url('/logout') }}">LOGOUT</a></li>
								<li class="mini-cart"><a href="{{ url('/profile#orders') }}">MY ORDERS</a></li>
							</ul>
						</li>
						@endif
					
				</ul>
			</div>
		</div>
	</nav>

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

	


