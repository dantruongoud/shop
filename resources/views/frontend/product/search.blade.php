@extends('frontend.layouts.layouts_login')
@section('content')
    <div class="features_items" style="padding: 0px 250px ;text-align: center"><!--features_items-->
        <h2 class="title text-center">Features Items</h2>

        @php
            $count = 0;
        @endphp
        @foreach ($data as $item)
            <div class="col-sm-4">
                <div class="product-image-wrapper" style="display: inline-block; margin: 15px">
                    <div class="single-products" id="PD1">
                        <div class="productinfo text-center">
                            <img style="height: 250px" src="{{ asset('frontend/images/product/' . $data_img[$count]) }}" alt="" />
                            @php
                                $count++;
                            @endphp

                            <h2 style="padding-top: 20px">${{ $item->price }}</h2>
                            <p style="padding: 10px 0px">{{ $item->name }}</p>
                            <a class="btn btn-default add-to-cart">
                                <i class="fa fa-shopping-cart"></i>Add to cart</a>
                        </div>
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <h2 style="padding-top: 20px">${{ $item->price }}</h2>
                                <p style="padding: 10px 0px">{{ $item->name }}</p>
                                <button type="submit" name="submit" id="add_to_cart" data-id="{{ $item->id }}" class="btn btn-default add-to-cart">
									<i class="fa fa-shopping-cart"></i>Add to
									cart
								</button>
								<a href="{{ url('/frontend/product/product-detail/' . $item->id) }}" class="btn btn-default add-to-cart">
									<i class="fa fa-shopping-cart"></i>
									Details
								</a>
                            </div>
                        </div>
                    </div>
                    <div class="choose">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                            <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                        </ul>
                    </div>
                </div>
            </div>  
        @endforeach

    </div><!--features_items-->
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            

            $('button#add_to_cart').click(function (e) { 
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    method: "POST",
                    url: "{{ url('/frontend/search/add_cart') }}",
                    data: {
                        id_product: id,
                        id_user: "{{ Auth::id() }}"
                    },
                    success: function (res) {
                        console.log(res);
                        $('a#sum_qty').text("Cart (" + res.sum + ")");
                    }
                });
                
            });
        });

    </script>
@endsection