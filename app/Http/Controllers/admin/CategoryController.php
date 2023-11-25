<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::orderBy('id', 'desc')->get();
        return view('admin.dashboards.product.category.index', compact('data'));
    }

    public function add_page()
    {
        return view('admin.dashboards.product.category.add');
    }

    public function create(CategoryRequest $request)
    {
        $found = true;
        $data = $request->all();

        if (empty($data['name'])) {
            $found = false;
        }

        if ($found) {
            Category::create($data);

            return redirect()->back()->with('success', __('Create category success'));
        } else {
            return redirect()->back()->withErrors('Create category errors');
        }
    }
    public function show($id)
    {
        $data = Category::where('id', $id)->first();
        return view('admin.dashboards.product.category.edit', compact('data'));
    }

    public function edit(CategoryRequest $request, $id)
    {
        $found = true;
        $category = Category::findOrFail($id);
        $data = $request->all();

        if (empty($data['name'])) {
            $found = false;
        }

        if ($found) {
            $category->update($data);

            return redirect()->back()->with('success', __('Update category success'));
        } else {
            return redirect()->back()->withErrors('Update category errors');
        }
    }


    public function destroy($id)
    {
        Category::where('id', $id)->delete();
        $data = Category::orderBy('id', 'desc')->get();


        return view('admin.dashboards.product.category.index', compact('data'));
    }
}
