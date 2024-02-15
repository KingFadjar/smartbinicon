<?php

namespace App\Http\Controllers;

use App\Models\Kapasitassampah;
use Illuminate\Http\Request;

class KapasitassampahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getCentimeterData()
     {
         // Example usage of UltrasonicController methods
         $ultrasonicController = new UltrasonicController();

         // Assuming you want to get all ultrasonic data
         $ultrasonics = $ultrasonicController->index();

         // You can then use $ultrasonics in your view or perform any other actions

         return view('get-centimeter-data', ['ultrasonics' => $ultrasonics]);
     }
}
