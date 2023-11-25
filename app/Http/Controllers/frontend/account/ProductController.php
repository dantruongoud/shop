<?php

namespace App\Http\Controllers\frontend\account;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\account\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index()
    {
        $userId = Auth::id();
        $data = Product::where('id_user', $userId)->first();

        return view('frontend/account/my-product', compact('data'));
    }

    public function add_page()
    {
        $categorys = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();

        return view('frontend/account/add', compact('categorys', 'brands'));
    }

    public function create()
    {
        $getProduct = Product::find(1);

        $getArrImage = json_decode($getProduct['photo'], true);
        dd($getArrImage);
        return view('frontend.account.add', compact('getArrImage'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        if($request->hasfile('photo'))
        {

            foreach($request->file('photo') as $image)
            {

                $name = $image->getClientOriginalName();
                $name_2 = "2".$image->getClientOriginalName();
                $name_3 = "3".$image->getClientOriginalName();

                //$image->move('upload/product/', $name);
                
                $path = public_path('frontend/images/product/' . $name);
                $path2 = public_path('frontend/images/product/' . $name_2);
                $path3 = public_path('frontend/images/product/' . $name_3);

                Image::make($image->getRealPath())->save($path);
                Image::make($image->getRealPath())->resize(50, 70)->save($path2);
                Image::make($image->getRealPath())->resize(200, 300)->save($path3);
                
                $data[] = $name;
            }
        }

        $product= new Product();
        $product->photo=json_encode($data);
        dd($product);
        $product->save();

        return back()->with('success', 'Your images has been successfully');
    }

}
