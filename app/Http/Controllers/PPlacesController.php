<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PPlace;
use App\PSpot;
use App\User;
use App\Review;
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
        $post->format_address = $request->input('format_address');

        $post->address = $request->input('address');
        $post->lat = $request->input('lat');
        $post->lng = $request->input('lng');
        $post->owner_id = auth()->user()->id;
        $post->save();
        return redirect('/pplaces')->with('success', 'Place Added');
    }

    public function storeComment(Request $request)
    {
        // Create Comment
        $post = new Review;

        $post->place_id = $request->input('place_id');
        $post->comment = $request->input('comment');
        $post->save();

        $type = $request->input('type');

        return redirect('/view/pplaces/'.$post->place_id.'/'.$type)->with('success', 'Comment Added');
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
        $pplace = DB::table('p_places')->where('id',$id)->get();
        $comb = array('pplace' => $pplace, 'pspots' => $pspots, 'id' => $id);
        
        //return ($comb);
        return view('pplaces.show')->with($comb);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id, $type)
    {
        //$pspot = DB::select('select * from p_spots where place_id = '.$id.'');
        // Gets Owner ID
        $owner_id = DB::table('p_places')
                    ->select('owner_id')
                    ->where('id', $id)->get()[0]->owner_id;
        
        // Gets Owner info
        $owner_info = DB::table('users')
                      ->select('first_name','last_name','phone','email')
                      ->where('id', $owner_id)->first();


        $place_info = DB::table('p_places')
                      ->select('address','format_address')
                      ->where('id', $id)->first();

        $pspots = DB::table('p_spots')->where('place_id', $id)->where('vehicle_type', $type)->get();

        $reviews = DB::select( DB::raw("SELECT u.first_name as first_name, u.last_name as last_name, r.comment as comment
                                        from review r, users u, p_places p 
                                        WHERE r.place_id = p.id
                                        AND p.owner_id = u.id" ) );
        
        $arr = array('owner_info' => $owner_info,
                      'place_info' => $place_info,
                      'pspots'     => $pspots,
                      'reviews'     => $reviews,
                      'id'         => $id,
                      'type'       => $type);

        return view('pplaces.view')->with($arr);
    }

    public function admin_view($id)
    {
        //$pspot = DB::select('select * from p_spots where place_id = '.$id.'');
        // Gets Owner ID
        $owner_id = DB::table('p_places')
                    ->select('owner_id')
                    ->where('id', $id)->get()[0]->owner_id;
        
        // Gets Owner info
        $owner_info = DB::table('users')
                      ->select('first_name','last_name','phone','email','nid')
                      ->where('id', $owner_id)->first();


        $place_info = DB::table('p_places')
                      ->select('id','address','format_address')
                      ->where('id', $id)->first();

        $pspots = DB::table('p_spots')->where('place_id', $id)->get();

        $reviews = DB::select( DB::raw("SELECT u.first_name as first_name, u.last_name as last_name, r.comment as comment
                                        from review r, users u, p_places p 
                                        WHERE r.place_id = p.id
                                        AND p.owner_id = u.id" ) );
        
        $arr = array('owner_info' => $owner_info,
                      'place_info' => $place_info,
                      'pspots'     => $pspots,
                      'review'     => $reviews,
                      'admin_id'   => auth()->user()->id);

        
        return view('pplaces.adminview')->with($arr);
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
       $place = PPlace::find($id);
       $place->verified_by = $request->input('verify');
       $place->save();
       return redirect('/home')->with('success', 'Parking Place Verfied');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $place = PPlace::find($id);
        $place->delete();
        return redirect('/home')->with('success', 'Parking Place Removed');
    }
}
