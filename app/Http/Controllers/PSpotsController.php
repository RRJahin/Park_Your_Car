<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PSpot;
use DB;

class PSpotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //return ($id);
        $pplace = DB::table('p_places')->where('id',$id)->get();
        $comb = array('pplace' => $pplace, 'id' => $id);
        return view('pspots.create')->with($comb);
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
            'vehicle_type' => 'required'
        ]);
        // Create Post
        $post = new PSpot;
        $post->place_id = $request->input('place_id');
        $post->rent_value = $request->input('rent_value');
        $post->location = $request->input('location');
        $post->vehicle_type = $request->input('vehicle_type');
        $post->availability = $request->input('available');
        $post->save();
        return redirect('/pplaces')->with('success', 'Parking Spot Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pspot = PSpot::find($id);
        //return ($pspot);
        //Check if post exists before deleting
        if (!isset($pspot)){
            return redirect('/pplaces')->with('error', 'No Post Found');
        }


        return view('pspots.edit')->with('pspot', $pspot);
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
        $this->validate($request, [
            'type' => 'required'
        ]);
        // Create Post
        $post = PSpot::find($id);
        $post->place_id = $request->input('place_id');
        $post->rent_value = $request->input('rent');
        $post->location = $request->input('location');
        $post->vehicle_type = $request->input('type');
        $post->availability = $request->input('available');
        $post->save();
        return redirect('/pplaces')->with('success', 'Parking Spot Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = PSpot::find($id);
        $post->delete();
        return redirect('/pplaces')->with('success', 'Post Removed');
    }
}
