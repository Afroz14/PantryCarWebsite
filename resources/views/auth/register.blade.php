
@section('register-content')
<div class="container-fluid hidden" id="signup-form">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-md-6">
					<div class="alert alert-danger hidden"></div>

					<form class="form-horizontal form-signup-email-passwd" role="form" method="POST" action="{{ url('/auth/register') }}" style="float:left">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">

						<div class="form-group">
							<label class="col-md-4 control-label">Name</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="name" value="{{ old('name') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">E-Mail Address</label>
							<div class="col-md-8">
								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Phone number</label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="phone-number" value="">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-8">
								<input type="password" class="form-control" name="cpassword">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" id="signup-button">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
					<div class="col-md-6">
					  <div class="social-login-links">
						 <button class="btn-social btn-fb" id="fb-login-button" onclick="location.href='{{ url('/facebook') }}';" >Sign up with Facebook</button>
						 <button class="btn-social btn-google" id="google-login-button" onclick="location.href='{{ url('/google') }}';">Sign up with Google</button>
					 </div>
				  </div>	
				</div>
			</div>
		</div>
		<div class="ajax_loader__wrapper hidden"></div>
	</div>
</div>
@endsection
