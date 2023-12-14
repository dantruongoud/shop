<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function logout()
    {
        session()->flush();
        Auth::logout();

        return view('frontend.login');
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->take(6)->get();
        $imageData = [];
        $data_img = [];

        foreach ($products as $item) {
            $jsonData = $item['photo'];
            
            $imageData[] = json_decode($jsonData, true);
        }

        foreach ($imageData as $value) {
            $data_img[] = $value[0];
        }
        return view('frontend.index', compact('products', 'data_img'));
    }

    public function show_product($id)
    {   
        $brands = Brand::orderBy('id', 'desc')->get();
        $data = Product::findOrFail($id);
        $img = json_decode($data['photo']);

        return view('frontend.product.product-details', compact('data', 'img', 'brands'));
    }

    public function add_cart(Request $request)
    {
        $data = $request->all();

        if (session()->has('cart')) {
            $cart = session('cart');

            
            $currentProduct = array_search($data['id_product'], array_column($cart, 'id_product'));

            if ($currentProduct == true) {
                
                $cart[$currentProduct]['qty'] += $data['qty'];
            } else {
                
                $cart[] = [
                    'id_product' => $data['id_product'],
                    'qty' => $data['qty'],
                    'id_user' => $data['id_user']
                ];
            }
        } else {
            $cart[] = [
                'id_product' => $data['id_product'],
                'qty' => $data['qty'],
                'id_user' => $data['id_user']
            ];
        }

        
        session(['cart' => $cart]);

        
        $sum_qty = array_sum(array_column($cart, 'qty'));

        return response()->json(['sum' => $sum_qty]);
    }


    public function index_add_cart(Request $request)
    {
        $data = $request->all();
        if (session()->has('cart')) {
            $cart = session('cart');

            
            $currentProduct = array_search($data['id_product'], array_column($cart, 'id_product')); // hàm này trả về false nếu ko tìm thấy và trả về interger nếu tìm thấy nên k thể so sánh == true được

            if ($currentProduct !== false) {
                
                $cart[$currentProduct]['qty'] += 1;
            } else {
                
                $cart[] = [
                    'id_product' => $data['id_product'],
                    'qty' => 1,
                    'id_user' => $data['id_user']
                ];
            }
        } else {
            $cart[] = [
                'id_product' => $data['id_product'],
                'qty' => 1,
                'id_user' => $data['id_user']
            ];
        }

        
        session(['cart' => $cart]);

        
        $sum_qty = array_sum(array_column($cart, 'qty'));

        return response()->json(['sum' => $sum_qty]);
    }

    public function cart() 
    {
        $cart = [];
        $data_img = [];
        $data = [];

        if (session()->has('cart')) {
            $cart = session('cart');


            foreach ($cart as $item) {
                $productId = $item['id_product'];
                $product = Product::findOrFail($productId);

                $data[] = [
                    'product' => $product,
                    'qty' => $item['qty']
                ];
            }
            // dd($data);
            foreach ($data as $item) {
                $jsonData = $item['product']->photo;
                $imageData[] = json_decode($jsonData, true);
            }

            foreach ($imageData as $value) {
                $data_img[] = $value[0];
            }

        }
        return view('frontend.cart.cart', compact('data', 'data_img'));
    }

    public function action_update(Request $request)
    {
        $cart = [];
        $data = $request->all();
        $new_qty = 0;
        $products = [];
        $total = 0;
        
        if (session()->has('cart')) {
            $cart = session('cart');
            foreach ($cart as $item) {
                $productId = $item['id_product'];
                $product = Product::findOrFail($productId);
                
                $products[] = $product;
            }
            if ($data['action'] == 'up') {

                foreach ($cart as &$item) {
                    if ($data['id_product'] == $item['id_product']) {
                        $item['qty'] += 1;
                        $new_qty = $item['qty'];
                        break;
                    }
                }

                foreach ($products as $value) {
                    if ($data['id_product'] == $value['id']) {
                        $total = $value['price'] * $new_qty;
                        break;
                    }
                }

                
            } else if ($data['action'] == 'down') {

                foreach ($cart as &$item) {
                    if ($data['id_product'] == $item['id_product']) {
                        $item['qty'] = max(0, $item['qty'] - 1);
                        $new_qty = $item['qty'];
                        break; 
                    }
                }

                foreach ($products as $value) {
                    if ($data['id_product'] == $value['id']) {
                        $total = $value['price'] * $new_qty;
                        break;
                    }
                }

            } else {

                foreach ($cart as $key => $item) {
                    if ($data['id_product'] == $item['id_product']) {
                        unset($cart[$key]);
                        break;
                    }
                }
            }

            
        }
        session()->put('cart', $cart);

        $sum_qty = array_sum(array_column($cart, 'qty'));

        $data = [
            'sum' => $sum_qty,
            'new_qty' => $new_qty,
            'total' => $total
        ];
        return response()->json($data);
    }

    public function check_out()
    {
        $cart = [];
        $data_img = [];
        $data = [];

        if (session()->has('cart')) {
            $cart = session('cart');


            foreach ($cart as $item) {
                $productId = $item['id_product'];
                $product = Product::findOrFail($productId);
                
                $data[] = [
                    'product' => $product,
                    'qty' => $item['qty']
                ];
            }
            // dd($data);
            foreach ($data as $item) {
                $jsonData = $item['product']->photo;
                $imageData[] = json_decode($jsonData, true);
            }

            foreach ($imageData as $value) {
                $data_img[] = $value[0];
            }

        }
        return view('frontend.product.checkout', compact('data', 'data_img'));
    }

    public function search(Request $request)
    {
        $key_search = $request->search;
        $data = [];
        $data_img = [];

        if (empty($key_search)) {

            return redirect()->back()->withErrors('Searching error');
        } else {
            $data = Product::where('name', 'like', '%' . $key_search . '%')->get();


            foreach ($data as $item) {
                $jsonData = $item['photo'];
                
                $imageData[] = json_decode($jsonData, true);
            }

            foreach ($imageData as $value) {
                $data_img[] = $value[0];
            }
        }
        return view('frontend.product.search', compact('data', 'data_img'));
    }

    public function search_add_cart(Request $request)
    {
        $data = $request->all();
        if (session()->has('cart')) {
            $cart = session('cart');

            
            $currentProduct = array_search($data['id_product'], array_column($cart, 'id_product')); // hàm này trả về false nếu ko tìm thấy và trả về interger nếu tìm thấy nên k thể so sánh == true được

            if ($currentProduct !== false) {
                
                $cart[$currentProduct]['qty'] += 1;
            } else {
                
                $cart[] = [
                    'id_product' => $data['id_product'],
                    'qty' => 1,
                    'id_user' => $data['id_user']
                ];
            }
        } else {
            $cart[] = [
                'id_product' => $data['id_product'],
                'qty' => 1,
                'id_user' => $data['id_user']
            ];
        }

        
        session(['cart' => $cart]);

        $sum_qty = array_sum(array_column($cart, 'qty'));

        return response()->json(['sum' => $sum_qty]);
    }

    public function shop()
    {
        $imageData = [];
        $data_img = [];
        $data = Product::orderBy('id', 'desc')->get();
        $categorys = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();

        foreach ($data as $item) {
            $jsonData = $item['photo'];
            
            $imageData[] = json_decode($jsonData, true);
        }

        foreach ($imageData as $value) {
            $data_img[] = $value[0];
        }

        return view('frontend.onepage.shop', compact('data', 'data_img', 'categorys', 'brands'));
    }

    public function research(Request $request)
    {
        $imageData = [];
        $data_img = [];
        $products = Product::query();
        
        // Lọc theo key search
        if (!empty($request->search)) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        // Lọc theo price
        if (!empty($request->price)) {
            $price = $request->price;

            switch ($price) {
                case '1':
                    $products->where('price', '<', 100);
                    break;

                case '2':
                    $products->whereBetween('price', [100, 500]);
                    break;

                case '3':
                    $products->where('price', '>', 500);
                    break;
                
            }
        }

        // Lọc theo danh mục
        if (!empty($request->category)) {
            $products->where('category', $request->category);
        }
         

        // Lọc theo thương hiệu
        if (!empty($request->brand)) {
            $products->where('brand', $request->brand);
        }

        // Lọc theo trạng thái
        if (!empty($request->status)) {
            $products->where('sale', $request->status);
        }

        $data = $products->get();
        
        // dd($data);
        foreach ($data as $item) {
            $jsonData = $item['photo'];
            
            $imageData[] = json_decode($jsonData, true);
        }

        foreach ($imageData as $value) {
            $data_img[] = $value[0];
        }

        $categorys = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();
        return view('frontend.onepage.shop', compact('data', 'data_img', 'categorys', 'brands'));
    }
    
    public function range_price(Request $request)
    {
        $products = Product::query();
        $data = $request->all();
        $data_img = [];
        $product = [];

        $range = explode(' : ', $data['range']);

        $products->where('price', '>=', $range[0])->where('price', '<=', $range[1]);

        $product = $products->get();
        foreach ($product as $item) {
            $jsonData = $item['photo'];
            
            $imageData[] = json_decode($jsonData, true);
        }

        foreach ($imageData as $value) {
            $data_img[] = $value[0];
        }
        
        $response = [
            'products' => $product,
            'data_img' =>  $data_img
        ];
        return response()->json($response);
    }
}
