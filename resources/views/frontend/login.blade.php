@extends('frontend.layouts.layouts_login')
@section('content')
<section id="form" style="margin-bottom: 30px; margin-top: 10px">
	<!--form-->
	<div class="container">
		<div class="row" style="display: flex;justify-content: center">
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form">
					<!--login form-->
					<h2>Login to your account</h2>
					<form method="POST">
						@csrf
						<input type="email" name="email" placeholder="Email..." />
						<input type="password" name="password" placeholder="Password..." />
						<span>
							<input name="remember_me" type="checkbox" class="checkbox">
							Keep me signed in
						</span>
						<div id="buttons">
							<button type="submit" name="submit" class="btn btn-default">Login</button>
							<a href="{{ url('/register') }}" type="submit" name="submit"
								class="btn btn-default">Register</a>
						</div>
						@if($errors->any())
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4><i class="icon fa fa-check"></i> Thông báo!</h4>
							<ul>
								@foreach($errors->all() as $error)
								<li>{{$error}}</li>
								@endforeach
							</ul>
						</div>
						@endif
					</form>
				</div>
				<!--/login form-->
			</div>
		</div>
	</div>
</section>
<!--/form-->
@endsection