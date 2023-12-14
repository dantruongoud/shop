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
        $imageData = [];
        $data_img = [];
        $userId = Auth::id();
        $data = Product::where('id_user', $userId)->orderBy('id', 'desc')->get();
        foreach ($data as $item) {
            $jsonData = $item['photo'];
            
            $imageData[] = json_decode($jsonData, true);
        }
        foreach ($imageData as $value) {
            $data_img[] = $value[0];
        }
        return view('frontend/account/my-product', compact('data', 'data_img'));
    }

    public function add_page()
    {
        $categorys = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();

        return view('frontend/account/add', compact('categorys', 'brands'));
    }
    public function create(ProductRequest $request)
    {
        $data = $request->all();
       
        if($request->hasfile('photo')){
            $photoFile = $request->file('photo');
            $data['photo'] = json_encode($this->handleFile($photoFile));
        }

        $data['id_user'] = Auth::id();
        $data['detail'] = $request->detail;
        $data['sale-value'] = $request['sale-value'];
        $product = Product::create($data);

        if ($product) {
          
            return redirect()->back()->with('success', __('Create Product success'));
        } else {
            return redirect()->back()->withErrors('Create Product error');
        }
    }

    /**ha
     * Store a newly created resource in storage.
     */
    public function handleFile($data)
    {
        $xx=[];

        foreach($data as $image)
        {
            $currentDate = date('YmdHis', strtotime(date('Y-m-d H:i:s')));
            $name = $currentDate.$image->getClientOriginalName();
            $name_2 = "2". $currentDate . $image->getClientOriginalName();
            $name_3 = "3" . $currentDate . $image->getClientOriginalName();

            
            if (!is_dir('frontend/images/product/')) {
                mkdir('frontend/images/product/');
            }
            $path = public_path('frontend/images/product/' . $name);
            $path2 = public_path('frontend/images/product/' . $name_2);
            $path3 = public_path('frontend/images/product/' . $name_3);
            

            Image::make($image->getRealPath())->save($path);
            Image::make($image->getRealPath())->resize(85, 84)->save($path2);
            Image::make($image->getRealPath())->resize(329, 380)->save($path3);
            
            $xx[] = $name;
        
        }
        return $xx;
    }

    public function show($id)
    {
        $data = Product::findOrFail($id);
        $list_img = json_decode($data['photo']);

        // dd($list_img);
        $categorys = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();

        return view('frontend.account.edit', compact('data', 'list_img','categorys', 'brands'));
    }

    public function update(ProductRequest $request, $id)
    {
        $found = true;
        $product = Product::findOrFail($id);
        $img = json_decode($product['photo'], true);

        $new_img = [];
        $img_unset = [];
        $getData = $request->all();


        if ($request->hasfile('photo') && !empty($request->checkbox)) 
        {

            $photoFile = $request->file('photo');

            $img_unset = $this->edit($request->checkbox, $img);
            $img_new_uploaded = $this->handleFile($photoFile);

            if (count($img_unset) + count($img_new_uploaded) > 3 ) {
                $found = false;
                return redirect()->back()->withErrors('You can only select a maximum of 3 images.');
            } else {
                $new_img = array_merge($img_unset, $img_new_uploaded);
            }

        } 
        else if (!empty($request->checkbox)) 
        {
            $img_unset = $this->edit($request->checkbox, $img);
            $new_img = $img_unset;

        } 
        else if ($request->hasFile('photo')) 
        {
            $photoFile = $request->file('photo');

            $img_new_uploaded = $this->handleFile($photoFile);

            if (count($img) + count($img_new_uploaded) > 3) {
                $found = false;
                return redirect()->back()->withErrors('You can only select a maximum of 3 images.');
            } else {
                $new_img = array_merge($img, $img_new_uploaded);
            }

        }

        
        if ($found) {
            if (!empty($new_img)) {
                $getData['photo'] = json_encode($new_img);
            }

            $product->update($getData);


            return redirect()->back()->with('success', __('Update Product success'));
        } else {
            return redirect()->back()->withErrors('Update Product error');
        }
    }


    public function edit($data, $list_img)
    {
        foreach ($data as $value) {
            $key = array_search($value, $list_img);
            if ($key !== false) {
                unset($list_img[$key]);
            }
        }

        // reset key without reordering
        $list_img = array_values($list_img);

        return $list_img;
    }


}
