<?php

namespace App\Http\Controllers\admin;

use App\Models\Blogs;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\BlogsRequest;
use App\Http\Requests\admin\EditBlogsRequest;
use Illuminate\Http\Request;

class BlogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs = Blogs::all();
        return view('admin/blog/list', compact('blogs'));
    }

    public function add()
    {
        return view('admin/blog/add');
    }

    public function create(BlogsRequest $request)
    {
        $data = $request->all();
        $file = $request->image;
        $create = true;

        if (!empty($file)) {
            $data['image'] = $file->getClientOriginalName();
        } else {
            $create = false;
        }

        if (empty($data['title']) || empty($data['description']) || empty($data['content']) || empty($data['image'])) {
            $create = false;
        }

        if ($create) {
            Blogs::create($data);

            if (!empty($file)) {
                $file->move('admin/blogs/image', $file->getClientOriginalName());
            }


            return redirect()->back()->with('success', __('Create Blogs success'));
        } else {
            return redirect()->back()->withErrors('Create Blogs error');
        }
    }

    public function edit($id)
    {
        $data = Blogs::findOrFail($id);
        return view('admin/blog/edit', compact('data'));
    }


    public function update(EditBlogsRequest $request, $id)
    {
        $data = Blogs::findOrFail($id);

        $getData = $request->all();
        $update = true;
        if (!empty($file)) {
            $getData['image'] = $file->getClientOriginalName();
        } else {
            $getData['image'] = $data->image;
        }

        if (empty($getData['title']) || empty($getData['description']) || empty($getData['content']) || empty($getData['image'])) {
            $update = false;
        }

        if ($data->update($getData) && $update) {

            if (!empty($file)) {
                $file->move('admin/blogs/image', $file->getClientOriginalName());
            }

            return redirect()->back()->with('success', __('Update Blog success'));
        } else {
            return redirect()->back()->withErrors('Update Blog error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        Blogs::where('id', $id)->delete();
        $blogs = Blogs::all();
        return view('admin/blog/list', compact('blogs'));
    }
}
