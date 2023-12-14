@extends('frontend.layouts.layout_account')
@section('content')
<div class="blog-post-area">
	<h2 class="title text-center">Create Product</h2>
	<div class="signup-form">
		<h2>Update your product</h2>

		<form method="POST" enctype="multipart/form-data">
			@csrf
			<input type="text" name="name" placeholder="Name" />
			<input type="number" name="price" placeholder="Price" />
			<div class="select" style="margin-bottom: 10px">
				<select name="category">
					<option value="">Please choose category</option>

					@if (isset($categorys))

					@foreach ($categorys as $item)
					<option value="{{ $item->id }}">{{ $item->name }}</option>
					@endforeach

					@endif
				</select>
			</div>
			<div class="select">
				<select name="brand">
					<option value="">Please choose brand</option>

					@if (isset($brands))
					@foreach ($brands as $item)

					<option value="{{ $item->id }}">{{ $item->name }}</option>

					@endforeach
					@endif

				</select>
			</div>
			<div class="select">
				<select name="sale" id="saleSelect">
					<option value="2">New</option>
					<option value="1">Sale</option>
				</select>
			</div>

			<div style="display: none" id="saleInputContainer">
				<div class="is-flex" style="align-items: center">
					<input style="width: 100px" type="number" name="sale-value" value="" placeholder="0"
						id="saleValueInput" />
					<span>%</span>
				</div>
			</div>

			<input type="text" name="company" placeholder="Company profile" />

			<div id="file-js-example" class="file has-name">
				<label class="file-label">
					<input class="file-input" type="file" name="photo[]" multiple onchange="updateFileList()">
					<span class="file-cta">
						<span class="file-icon">
							<i class="fas fa-upload"></i>
						</span>
						<span class="file-label">
							Choose files…
						</span>
					</span>
				</label>
				<div id="file-list"></div>
			</div>


			<textarea class="textarea" name="detail" placeholder="Details"></textarea>

			<div class="buttons">
				<button type="submit" name="submit" class="button is-success" style="border-radius: 4px">Save
					changes</button>
				<a href="{{ url('/frontend/account/my-product') }}" class="button is-danger">Cancel</a>
			</div>
		</form>

		@if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            {{session('success')}}
        </div>
        @endif
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
	</div>
</div>

@endsection