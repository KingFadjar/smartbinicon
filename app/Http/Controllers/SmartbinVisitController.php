<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rute;

class SmartbinVisitController extends Controller
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

    public function getSmartbinData()
     {
         // Example usage of UltrasonicController methods
         $ultrasonicController = new UltrasonicController();

         // Assuming you want to get all ultrasonic data
         $ultrasonics = $ultrasonicController->index();

         // You can then use $ultrasonics in your view or perform any other actions

         return view('smartbin-visit-rute', ['ultrasonics' => $ultrasonics]);
     }
}
