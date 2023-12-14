@extends('frontend.layouts.layouts_login')
@section('content')
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="step-one">
				<h2 class="heading">Step1</h2>
			</div>
			<div class="checkout-options">
				<h3>New User</h3>
				<p>Checkout options</p>
				<ul class="nav">
					<li>
						<label><input type="checkbox"> Register Account</label>
					</li>
					<li>
						<label><input type="checkbox"> Guest Checkout</label>
					</li>
					<li>
						<a href=""><i class="fa fa-times"></i>Cancel</a>
					</li>
				</ul>
			</div><!--/checkout-options-->

			<div class="register-req">
				<p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">

					@if (Auth::check())
						<a href="{{ url('/frontend/check-out/send-mail') }}" class="btn btn-primary">Get my Order</a>
					@else
						<div class="col-sm-3">
							<div class="shopper-info">
								<p>Information Delivery</p>
								<form>
									<input type="text" placeholder="Display Name">
									<input type="text" placeholder="User Name">
									<input type="password" placeholder="Password">
									<input type="password" placeholder="Confirm password">
								</form>
								<button type="submit" name="submit" class="btn btn-primary" href="">Create</button>
								
							</div>
						</div>				
					@endif
				</div>
			</div>

			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>

			{{-- // cart --}}
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description">Description</td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
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
								<td style="width: 500px" class="cart_description">
									<h4><a href="">{{ $item['product']->name }}</a></h4>
									<p>Web ID: {{ $item['product']->id }}</p>
								</td>
								<td style="width: 100px" class="cart_price">
									<p>$ {{ $item['product']->price }}</p>
								</td>
								<td class="cart_quantity">
									<div class="cart_quantity_button">

										<input id="{{ $item['product']->id }}" class="cart_quantity_input" type="text" name="quantity" value="{{ $item['qty'] }}" autocomplete="off" size="2">

										
									</div>
								</td>
								<td class="cart_total">
									@php
										$total_checkout += $item['qty'] * $item['product']->price;
										$total = $item['qty'] * $item['product']->price;
									@endphp
									<p class="cart_total_price">$ {{ $total }}</p>
								</td>
								
							</tr>
						@endforeach
						@else
							<tr>
								<td colspan="4">Chưa có sản phẩm nào trong giỏ hàng</td>
							</tr>
						@endif
						

						<tr>
							<td colspan="4">&nbsp;</td>
							<td colspan="2">
								<table class="table table-condensed total-result">
									<tr>
										<td>Cart Sub Total</td>
										<td>$59</td>
									</tr>

									<tr>
										<td>Exo Tax</td>
										<td>$2</td>
									</tr>

									<tr class="shipping-cost">
										<td>Shipping Cost</td>
										<td>Free</td>										
									</tr>
									<tr>
										<td>Total</td>
										<td><span>$ {{ $total_checkout }}</span></td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="payment-options">
					<span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
					<span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
					<span>
						<label><input type="checkbox"> Paypal</label>
					</span>
				</div>
		</div>
	</section> <!--/#cart_items-->
@endsection