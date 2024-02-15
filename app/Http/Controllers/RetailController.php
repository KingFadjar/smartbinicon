<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DilRetail;
use App\Models\PopAmarta;

class RetailController extends Controller
{

    public function index()
    {
        $retailData = DilRetail::getpelanggan_iconnet();
        $popData = PopAmarta::getPopData();
        return view('retail', compact('retailData', 'popData'));
    }

}


