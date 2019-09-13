<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('hello');
        return view('home');
    }

    public function userHome()
    {
        $id = auth()->user()->id;
        $role = DB::table('users')->where('id', $id)->value('role');

        if ($role == 'Parking Place Owner') {
            return redirect('/pplaces');
            // return view('dashboards.parkingPlaceOwner');
        } elseif ($role == 'Vehicle Owner') {
            $locations = DB::table('p_places')->select('id','address','lat', 'lng')
                                              ->whereNotNull('verified_by')->get();
            //dd($lat_lng);
            return view('dashboards.vehicleOwner')->with('locations', $locations);
        } else {
            return view('dashboards.admin');
        }
    }

    public function editProfile()
    {
        $profile = User::find(auth()->user()->id);
        //return ($profile);

        return view('dashboards.edit')->with('profile', $profile);
    }

    public function updateProfile(Request $request, $id)
    {
        $profile = User::find(auth()->user()->id);
        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');
        $profile->phone = $request->input('phone');
        $profile->save();
        //return("Success");
        if($profile->role == "Parking Place Owner"){
            return redirect('/pplaces')->with('success', 'Profile Updated');
        }else{
            return redirect('/home')->with('success', 'Profile Updated');
        }
    }
}
