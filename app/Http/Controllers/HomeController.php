<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            return view('dashboards.vehicleOwner');
        } else {
            return view('dashboards.admin');
        }

        // $pplaces = PPLace::all();
        // $temp = DB::select('select * from users');
        // //$temp1 = DB::table('users')->where('id', auth()->user()->id)->pluck('first_name');
        // //$temp2 = DB::table('users')->where('id', auth()->user()->id)->pluck('last_name');
        // //$comb = array('temp1'=> $temp1, 'temp2'=> $temp2, 'pplaces' => $pplaces);
        // $comb = array('temp' => $temp, 'pplaces' => $pplaces, 'id' => auth()->user()->id);
        // return view('pplaces.index')->with($comb);
    }
}
