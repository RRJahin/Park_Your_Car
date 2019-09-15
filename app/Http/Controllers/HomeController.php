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
            return view('dashboards.vehicleOwnerHome');
        } else {
            return view('dashboards.admin');
        }
    }

    public function vHome($id)
    {
        //return ("Hello");
        $locations = DB::select( DB::raw("SELECT pp.id,pp.address,pp.lat, pp.lng
        from p_places pp
        WHERE pp.verified_by IS NOT NULL 
        AND (
            SELECT COUNT(*)
            from p_spots ps
            WHERE pp.id = ps.place_id AND ps.vehicle_type = '$id'
        ) > 0") );
        
        //$locations = DB::table('p_places')->select('id','address','lat', 'lng')
        //                                    ->whereNotNull('verified_by')->get();
        $comb = array('locations'=> $locations, 'type' => $id);
        //dd($lat_lng);
        //return ($locations);
        return view('dashboards.vehicleOwner')->with($comb);
    }

    /*
        SELECT pp.id,pp.address,pp.lat, pp.lng
from p_places pp
WHERE pp.verified_by NOT NULL 
AND (
	SELECT conut(*)
	from p_pspots ps
	WHERE pp.id = ps.place_id
) > 0

    */

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
