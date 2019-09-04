<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PPlace;
use App\PSpot;
use DB;

class PPlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        //$pplaces = PPLace::find(auth()->user()->id)->toArray();
        $pplaces = DB::table('p_places')->where('owner_id',auth()->user()->id)->get();
        $temp = DB::select('select * from users');
        //$temp1 = DB::table('users')->where('id', auth()->user()->id)->pluck('first_name');
        //$temp2 = DB::table('users')->where('id', auth()->user()->id)->pluck('last_name');
        //$comb = array('temp1'=> $temp1, 'temp2'=> $temp2, 'pplaces' => $pplaces);
        $comb = array('temp' => $temp, 'pplaces' => $pplaces, 'id' => auth()->user()->id);
        return view('dashboards.parkingPlaceOwner')->with($comb);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pplaces.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'address' => 'required'
        ]);
        // Create Post
        $post = new PPlace;
        $post->address = $request->input('address');
        $post->lat = $request->input('lat');
        $post->lng = $request->input('lng');
        $post->owner_id = auth()->user()->id;
        $post->save();
        return redirect('/pplaces')->with('success', 'Place Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$pspot = DB::select('select * from p_spots where place_id = '.$id.'');
        
        $pspots = DB::table('p_spots')->where('place_id',$id)->get();
        //return ($pspots);
        $comb = array('pspots' => $pspots, 'id' => $id);
        
        return view('pplaces.show')->with($comb);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
