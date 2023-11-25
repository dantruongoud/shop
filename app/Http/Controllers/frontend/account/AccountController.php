<?php

namespace App\Http\Controllers\frontend\account;

use App\Http\Controllers\Controller;
use App\Http\Requests\frontend\account\AccountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $data = User::findOrFail($userId);

        return view('frontend/account/update', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update(AccountRequest $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);

        $getData = $request->all();
        $file = $request->avatar;

        if (!empty($file)) {
            $getData['avatar'] = $file->getClientOriginalName();
        }
        if (!empty($getData['password'])) {
            $getData['password'] = bcrypt($getData['password']);
        } else {
            $getData['password'] = $user->password;
        }

        if ($user->update($getData)) {
            if (!empty($file)) {
                $file->move('frontend/images/user-avatar/', $file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Update profile success'));
        } else {
            return redirect()->back()->withErrors('Update profile error');
        }
    }
}
