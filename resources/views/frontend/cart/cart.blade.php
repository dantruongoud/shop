@extends('frontend.layouts.layouts_login')
@section('content')
<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
				<li><a href="{{ url('/frontend/index') }}">Home</a></li>
				<li class="active">Shopping Cart</li>
			</ol>
		</div>
		<div class="table-responsive cart_info">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Item</td>
						<td class="description"></td>
						<td class="price">Price</td>
						<td class="quantity">Quantity</td>
						<td class="total">Total</td>
						<td></td>
					</tr>
				</thead>
				<tbody>

					@php
						$count = 0;
						$total_checkout = 0;
					@endphp

					@if (!empty($data))
					@foreach ($data as $item)
						<tr>
							<td class="cart_product">
								<a href="">
									<img style="width: 130px" src="{{ asset('frontend/images/product/' . $data_img[$count]) }}" alt="">
									@php
										$count++
									@endphp
								</a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{ $item['product']->name }}</a></h4>
								<p>Web ID: {{ $item['product']->id }}</p>
							</td>
							<td class="cart_price">
								<p>$ {{ $item['product']->price }}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<button data-id="{{ $item['product']->id }}" class="cart_quantity_up" id="{{ $item['product']->id }}"> + </button>

									<input id="{{ $item['product']->id }}" class="cart_quantity_input" type="text" name="quantity" value="{{ $item['qty'] }}" autocomplete="off" size="2">

									<button id="{{ $item['product']->id }}" class="cart_quantity_down"> - </button>
								</div>
							</td>
							<td class="cart_total">
								@php
									$total_checkout += $item['qty'] * $item['product']->price;
									$total = $item['qty'] * $item['product']->price;
								@endphp
								<p id="{{ $item['product']->id }}" class="cart_total_price">$ {{ $total }}</p>
							</td>
							<td class="cart_delete" style="margin-top: 15px">
								<button id="{{ $item['product']->id }}" class="cart_quantity_delete"><i class="fa fa-times"></i></button>
							</td>
						</tr>
					@endforeach
					@else
						<tr>
							<td colspan="4">Chưa có sản phẩm nào trong giỏ hàng</td>
						</tr>
					@endif
					
				</tbody>
			</table>
		</div>
	</div>
</section> <!--/#cart_items-->

<section id="do_action">
	<div class="container">
		<div class="heading">
			<h3>What would you like to do next?</h3>
			<p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="chose_area">
					<ul class="user_option">
						<li>
							<input type="checkbox">
							<label>Use Coupon Code</label>
						</li>
						<li>
							<input type="checkbox">
							<label>Use Gift Voucher</label>
						</li>
						<li>
							<input type="checkbox">
							<label>Estimate Shipping & Taxes</label>
						</li>
					</ul>
					<ul class="user_info">
						<li class="single_field">
							<label>Country:</label>
							<select>
								<option>United States</option>
								<option>Bangladesh</option>
								<option>UK</option>
								<option>India</option>
								<option>Pakistan</option>
								<option>Ucrane</option>
								<option>Canada</option>
								<option>Dubai</option>
							</select>
							
						</li>
						<li class="single_field">
							<label>Region / State:</label>
							<select>
								<option>Select</option>
								<option>Dhaka</option>
								<option>London</option>
								<option>Dillih</option>
								<option>Lahore</option>
								<option>Alaska</option>
								<option>Canada</option>
								<option>Dubai</option>
							</select>
						
						</li>
						<li class="single_field zip-field">
							<label>Zip Code:</label>
							<input type="text">
						</li>
					</ul>
					<a class="btn btn-default update" href="">Get Quotes</a>
					<a class="btn btn-default check_out" href="">Continue</a>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="total_area">
					<ul>
						<li>Cart Sub Total <span>$59</span></li>
						<li>Eco Tax <span>$2</span></li>
						<li>Shipping Cost <span>Free</span></li>
						<li>Total <span>${{ $total_checkout }}</span></li>
					</ul>
						<a class="btn btn-default update" href="">Update</a>
						<a class="btn btn-default check_out" href="">Check Out</a>
				</div>
			</div>
		</div>
	</div>
</section><!--/#do_action-->

<script type="text/javascript">
	$(document).ready(function () {
		$.ajaxSetup({
			headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
		});

		$('.cart_quantity_up').click(function (e) {
			var productId = $(this).attr('id');
			updateQuantity(productId, 'up');
		});

		$('.cart_quantity_down').click(function () {
			var productId = $(this).attr('id');
			updateQuantity(productId, 'down');
		});
		$("button.cart_quantity_delete").click(function () {
			var productId = $(this).attr('id');
			updateQuantity(productId, 'delete');
			$(this).closest('tr').remove();
		});

		function updateQuantity(productId, action) {

			$.ajax({
				
				method: "POST",
				url: "{{ url('/frontend/cart') }}",
				data: {
					id_product: productId,
					action: action
				},
				success: function (res) {

					if (res.new_qty >= 0) {
						$('input.cart_quantity_input[id="' + productId + '"]').val(res.new_qty);
					} else {
						$('input.cart_quantity_input[id="' + productId + '"]').closest('tr').remove();
					}

					$('p.cart_total_price[id="' + productId + '"]').text('$ ' + res.total);

					
					$('a#sum_qty').text("Cart (" + res.sum + ")");

				}
			});
		}
	});
</script>
@endsection