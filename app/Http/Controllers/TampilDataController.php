<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TampilData;

class TampilDataController extends Controller
{
    public function tampilData()
    {
        $data = TampilData::all();

        // You can return the data to a view or in JSON format, depending on your needs
        return response()->json(['data' => $data]);
        // or return view('your_view')->with('data', $data);
    }
}
