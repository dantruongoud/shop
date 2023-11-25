<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('admin/dashboards/dashboard');
    }


    public function profile()
    {
        $user = Auth::user();

        $userId = $user->id;
        $data = DB::table('users')->where('id', $userId)->first();
        return view('admin/dashboards/pages-profile', compact('data'));
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        $userId = Auth::id();
        $data = User::findOrFail($userId);

        $getData = $request->all();
        $file = $request->avatar;
        if (!empty($file)) {
            $getData['avatar'] = $file->getClientOriginalName();
        }

        if (!empty($getData['password'])) {
            $getData['password'] = bcrypt($getData['password']);
        } else {
            $getData['password'] = $data->password;
        }

        if (!empty($getData['name'])) {
            $getData['name'] = $getData['name'];
        } else {
            $getData['name'] = $data->name;
        }

        if (!empty($getData['phone'])) {
            $getData['phone'] = $getData['phone'];
        } else {
            $getData['phone'] = $data->phone;
        }

        if (!empty($getData['address'])) {
            $getData['address'] = $getData['address'];
        } else {
            $getData['address'] = $data->address;
        }

        if (!empty($getData['id_country'])) {
            $getData['id_country'] = $getData['id_country'];
        } else {
            $getData['id_country'] = $data->id_country;
        }

        if ($data->update($getData)) {
            if (!empty($file)) {
                $file->move('images/avatar', $file->getClientOriginalName());
            }
            return redirect()->back()->with('success', __('Update profile success'));
        } else {
            return redirect()->back()->withErrors('Update profile error');
        }
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
