<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PopAmarta;
use App\Models\DilJatengKorporat;

class KorporatController extends Controller
{


    public function index()
    {
        $popData = PopAmarta::getPopData();
        $dilData = DilJatengKorporat::getDilJatengKorporat();
        return view('korporat', ['popData' => $popData,
                                  'dilData' => $dilData
                                ]);
       
        //return view('korporat');
    }
}


