<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Brand::orderBy('id', 'desc')->get();

        return view('admin.dashboards.product.brand.index', compact('data'));
    }

    public function add_page()
    {
        return view('admin.dashboards.product.brand.add');
    }

    public function create(BrandRequest $request)
    {
        $found = true;
        $data = $request->all();

        if (empty($data['name'])) {
            $found = false;
        }

        if ($found) {
            Brand::create($data);

            return redirect()->back()->with('success', __('Create brand success'));
        } else {
            return redirect()->back()->withErrors('Create brand errors');
        }
    }


    public function show($id)
    {
        $data = Brand::where('id', $id)->first();
        return view('admin.dashboards.product.brand.edit', compact('data'));
    }

    public function edit(BrandRequest $request, $id)
    {
        $found = true;
        $brand = Brand::findOrFail($id);
        $data = $request->all();

        if (empty($data['name'])) {
            $found = false;
        }

        if ($found) {
            $brand->update($data);
            return redirect()->back()->with('success', __('Update brand success'));
        } else {
            return redirect()->back()->withErrors('Update brand errors');
        }
    }


    public function destroy($id)
    {
        Brand::where('id', $id)->delete();
        $data = Brand::orderBy('id', 'desc')->get();


        return view('admin.dashboards.product.brand.index', compact('data'));
    }
}
