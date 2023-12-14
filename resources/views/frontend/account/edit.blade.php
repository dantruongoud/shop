@extends('frontend.layouts.layout_account')
@section('content')
<div class="blog-post-area">
	<h2 class="title text-center">Create Product</h2>
	<div class="signup-form">
		<h2>Update your product</h2>

		<form method="POST" enctype="multipart/form-data">
			@csrf
			<input type="text" name="name" value="{{ $data->name }}" placeholder="Name" />
			<input type="number" value="{{ $data->price }}" name="price" placeholder="Price" />
			<div class="select" style="margin-bottom: 10px">
				<select name="category" value="{{ $data->category }}">
					<option value="">Please choose category</option>

					@if (isset($categorys))

					@foreach ($categorys as $item)
                    @if ($item->id == $data->category)
					<option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                        
                    @else
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endif
					@endforeach

					@endif
				</select>
			</div>
			<div class="select">
				<select name="brand" value="{{ $data->brand }}">
					<option value="">Please choose brand</option>

					@if (isset($brands))
					@foreach ($brands as $item)
                    @if ($item->id == $data->brand)
                        <option selected value="{{ $item->id }}">{{ $item->name }}</option>
                    @else
					    <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endif

					@endforeach
					@endif

				</select>
			</div>
			<div class="select">
				<select name="sale" id="saleSelect" value="{{ $data->sale }}">
					@if ($data->sale == 0)
					<option value="0" selected>New</option>
					<option value="1" >Sale</option>
					@else
					<option value="0" >New</option>
					<option value="1" selected>Sale</option>
					@endif
				</select>
			</div>
			@if ($data->sale == 1)
				<div id="saleInputContainer">
					<div class="is-flex" style="align-items: center">
						<input style="width: 100px" type="number" name="sale-value" value="{{ $data['sale-value'] }}" placeholder="0"
							id="saleValueInput" />
						<span>%</span>
					</div>
				</div>
			@endif

			<input type="text" value="{{ $data->company }}" name="company" placeholder="Company profile" />

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
					<div id="file-list"></div>
				</label>
			</div>
            <div id="file-list">

				@if (!empty($list_img))
					@foreach ($list_img as $item)
						<label class="checkbox-container">
							<img style="width: 80px;" src="{{ asset('frontend/images/product/' . $item) }}" />
							<input type="checkbox" name="checkbox[]" value="{{ $item }}">
						</label>
					@endforeach
					<p style="font-size: 14px; color: red">* Hình được chọn sẽ được xóa khi ấn Update</p>
				@endif
				
            </div>


			<textarea class="textarea" name="detail" placeholder="Details">{{ $data->detail }}</textarea>

			<div class="buttons" style="margin-top: 10px">
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