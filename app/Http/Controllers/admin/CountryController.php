<?php

namespace App\Http\Controllers\admin;

use App\Models\Country;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CountrysRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view('admin/dashboards/country', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function add()
    {
        return view('admin/dashboards/createCountry');
    }


    public function create(CountrysRequest $request)
    {
        $userId = Auth::id();

        $data = $request->all();
        $data['id_user'] = $userId;
        if (isset($data['name'])) {
            $country = Country::create($data);
            if ($country) {
                return redirect()->back()->with('success', __('Create country success'));
            } else {
                return redirect()->back()->withErrors('Create country error');
            }
        } else {
            return redirect()->back()->withErrors('Name is required');
        }
    }

    public function edit($id)
    {
        $data = Country::findOrFail($id);

        return view('admin/dashboards/editCountry', compact('data'));
    }

    public function update(CountrysRequest $request, $id)
    {
        $data = Country::findOrFail($id);
        $getData = $request->all();
        if (empty($getData['name'])) {
            return redirect()->back()->withErrors('Update profile error');
        }
        if ($data->update($getData)) {

            return redirect()->back()->with('success', __('Update Country success'));
        } else {
            return redirect()->back()->withErrors('Update Country error');
        }
    }

    public function delete($id)
    {
        Country::where('id', $id)->delete();
        $countries = Country::all();
        return view('admin/dashboards/country', compact('countries'));
    }
}
