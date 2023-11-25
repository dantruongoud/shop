@extends('frontend.layouts.layout_account')
@section('content')
<div class="blog-post-area">
	<h2 class="title text-center">Update user</h2>
	<div class="signup-form">
		<h2>Update your infomation</h2>
		<form method="POST" enctype="multipart/form-data">
			@csrf
			<label for="">Full Name:</label>
			<input type="text" name="name" value="{{ $data->name }}" placeholder="Name" />

			<label for="">Email Address:</label>
			<input type="email" name="email" value="{{ $data->email }}" disabled />

			<label for="">Password:</label>
			<input type="password" name="password" value="" />

			<label for="">Address:</label>
			<input type="text" name="address" placeholder="Enter your address..." value="{{ $data->address }}" />

			<label for="">Avatar:</label>
			<input style="background-color: #fff" type="file" name="avatar" />

			@if (!empty($data->avatar))
			<img src="{{ asset('frontend/images/user-avatar/' . $data->avatar) }}" alt="IMG"
				style="width: 120px; height: 120px; margin-bottom: 20px">
			@endif


			<button type="submit" name="submit" class="btn btn-default">Update</button>
		</form>
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
		@if(session('success'))
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-check"></i> Thông báo!</h4>
			{{session('success')}}
		</div>
		@endif
	</div>
</div>
@endsection