@extends('frontend.layouts.layout_blog')
@section('content')
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Features Items</h2>
        <div>
            <form id="search_bar" method="post">
                @csrf
                <input class="input" name="search" type="text" placeholder="Enter name product">
                <div class="select is-rounded">
                    <select name="price">
                        <option value="">Choose Price</option>
                        <option value="1">< $100</option>
                        <option value="2">$100 - $500</option>
                        <option value="3">> $500</option>
                    </select>
                </div>
                <div class="select is-rounded">
                    <select name="category">
                        <option value="">Category</option>
    
                        @if (isset($categorys))
    
                        @foreach ($categorys as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
    
                        @endif
                    </select>
                </div>
                <div class="select is-rounded">
                    <select name="brand">
                        <option value="">Brand</option>
    
                        @if (isset($brands))
    
                        @foreach ($brands as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
    
                        @endif
                    </select>
                </div>
                <div class="select is-rounded">
                    <select name="status">
                        <option value="">Status</option>
                        <option value="2">New</option>
                        <option value="1">Sale</option>
                    </select>
                </div>
                <button type="submit" name="submit" class="button is-warning">Search</button>
            </form>
        </div>
        @php
            $count = 0;
        @endphp

        @if ($data->isNotEmpty())
            @foreach ($data as $item)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img style="height: 250px" src="{{ asset('frontend/images/product/' . $data_img[$count]) }}" alt="" />

                                @php
                                    $count++
                                @endphp
                                <h2 style="padding-top: 20px">${{ $item->price }}</h2>
                                <p style="padding: 10px 0px">{{ $item->name }}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h2 style="padding-top: 20px">${{ $item->price }}</h2>
                                    <p style="padding: 10px 0px">{{ $item->name }}</p>
                                    <button type="submit" name="submit" id="add_to_cart" data-id="" class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>Add to
                                        cart
                                    </button>
                                    <a href="{{ url('/frontend/product/product-detail/') }}" class="btn btn-default add-to-cart">
                                        <i class="fa fa-shopping-cart"></i>
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href=""><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                <li><a href=""><i class="fa fa-plus-square"></i>Add to compare</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
            
        @else
            <div style="display: flex; justify-content: center; padding-top: 100px; font-size: 18px">
                <p>Không tìm thấy sản phẩm phù hợp</p>
            </div>
        @endif


        
    </div><!--features_items-->
@endsection