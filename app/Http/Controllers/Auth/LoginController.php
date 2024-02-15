<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\PopAmarta;
use App\Models\DilJatengKorporat;
use App\Models\DilRetail;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('Role_1')->only(['korporat','retail']);
        $this->middleware('Role_2')->only(['korporat','retail']);
        $this->middleware('Role_4')->only(['korporat']);
        $this->middleware('Role_3')->only(['retail']);
    }

    public function korporat()
    {
        $popData = PopAmarta::getPopData();
        $dilData = DilJatengKorporat::getDilJatengKorporat();
        return view('korporat', [
            'popData' => $popData,
            'dilData' => $dilData
        ]);
    }

    public function retail()
    {
        $retailData = DilRetail::getpelanggan_iconnet();
        $popData = PopAmarta::getPopData();
        return view('retail', compact('retailData', 'popData'));
    }

}
