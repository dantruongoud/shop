@extends('frontend.layouts.layout_account')
@section('content')
<div class="table-responsive cart_info">
	<table class="table table-condensed">

		<thead>
			<tr class="cart_menu" style="background-color: #FE980F; font-weight: 500; height: 35px;">
				<td class="image">Item</td>
				<td class="description">Description</td>
				<td class="price">Price</td>
				<td class="total">Action</td>
			</tr>
		</thead>

		<tbody>
			@if (!empty($data))
			@php
				$count = 0;
			@endphp
			@foreach ($data as $item)
			<tr style="border-bottom: 1px solid #ccc"> 
				<td class="cart_product" style="width: 130PX;">
					<a href="#">
						<img src="{{ asset('frontend/images/product/' . $data_img[$count]) }}" alt="">
						@php
							$count++
						@endphp
					</a>
				</td>
				<td class="cart_description" style="width: 65%">
					<h4><a href="">
							{{ $item->name }}
						</a>
					</h4>
					<p>Product ID:
						{{ $item['id'] }}
					</p>
				</td>
				<td class="cart_price">
					<p>
						{{ $item['price'] }}
					</p>
				</td>
				<td class="cart_delete is-flex">
					<a href="{{ url('/frontend/account/my-product/edit/' . $item->id) }}" class="cart_quantity_edit">
						<span class="material-icons material-icons-outlined">
							edit
						</span>
					</a>
					<a class="cart_quantity_delete" href="">
						<i class="fa fa-times"></i>
					</a>

				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="4">Chưa có sản phẩm nào</td>
			</tr>

			@endif

		</tbody>
	</table>
	<a href="{{ url('/frontend/account/my-product/add') }}">
		<button style="margin-bottom: 50px" class="button is-danger is-rounded">Thêm sản
			phẩm</button>
	</a>
</div>
@endsection