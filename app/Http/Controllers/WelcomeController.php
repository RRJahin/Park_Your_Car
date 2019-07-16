<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function regAsVehicle()
    {
        $data = array('role' => 'Vehicle Owner');
        return view('auth/register')->with($data);
    }

    public function regAsPPlace()
    {
        $data = array('role' => 'Parking Place Owner');
        return view('auth/register')->with($data);
    }
}
