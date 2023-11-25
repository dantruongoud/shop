<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\LoginRequest;
use App\Http\Requests\frontend\MemberRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{

    public function index()
    {
        return view('frontend/register');
    }


    public function create(MemberRequest $request)
    {
        $found = true;
        $data = $request->all();

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $found = false;
        }

        if ($found == true) {
            $data['level'] = 0;
            User::create($data);

            return redirect()->back()->with('success', __('Register success'));
        } else {
            return redirect()->back()->withErrors('Register error');
        }
    }

    public function login_page()
    {
        return view('frontend/login');
    }

    public function login(LoginRequest $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password,
            'level' => 0
        ];


        if (Auth::attempt($login)) {
            return redirect('/frontend/index');
        } else {
            return redirect()->back()->withErrors('Email or password is not correct...');
        }
    }
}
