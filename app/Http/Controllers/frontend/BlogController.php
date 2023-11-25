<?php

namespace App\Http\Controllers\frontend;


use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\CommentRequest;
use App\Models\Blogs;
use App\Models\Comments;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class BlogController extends Controller
{

    public function index()
    {
        $data = Blogs::orderBy('id', 'desc')->Paginate(3);
        return view('frontend/blog/blog', compact('data'));
    }

    public function detail($id)
    {
        // Xử lý dữ liệu blog và rating
        $data = Blogs::findOrFail($id);

        $preBlog = Blogs::where('id', '>', $id)->orderBy('id')->first();

        $nextBlog = Blogs::where('id', '<', $id)->orderBy('id', 'desc')->first();

        $avg = Rate::avg('rate');
        $avg = round($avg);
        $sum_rate = Rate::where('id_blog', $id)->count();

        // Xử lý dữ liệu comment
        $data_cmt = Comments::where('id_blog', $id)->orderBy('id', 'asc')->get();

        // Xử lý dữ liệu user theo comment
        $data_id_user = Comments::select('id_user')->first();
        $user_id = $data_id_user->id_user;

        $user = User::find($user_id);

        if ($user) {
            $name = $user->name;
            $avatar = $user->avatar;


            $user_info = compact('name', 'avatar');
        }

        return view('frontend/blog/blog-detail', compact('data', 'nextBlog', 'preBlog', 'avg', 'sum_rate', 'data_cmt', 'user_info'));
    }

    public function rating(Request $request)
    {
        $data = $request->all();
        // dd($data);
        Rate::create($data);
    }

    public function comment(CommentRequest $request)
    {
        $data = $request->all();
        $data['level'] = 0;
        Comments::create($data);
    }

    public function reply($id)
    {

    }
}
