<?php


use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\SmartbinVisitController;
use App\Http\Controllers\KapasitassampahController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\TampilDataController;
use App\Http\Controllers\DeleteDataController;
use App\Http\Controllers\UltrasonicController;

/*
Develop by https://www.linkedin.com/in/muhamad-fajar-6ab261233/
*/


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [Login::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/get-lokasi', [LokasiController::class, 'getLokasi'])->name('get-lokasi');
Route::get('/get-rute', [RuteController::class, 'getSmartbinData'])->name('get-rute');
Route::get('/smartbin-visit-rute', [SmartbinVisitController::class, 'getSmartbinData'])->name('smartbin-visit-rute');
Route::get('/get-centimeter-data', [KapasitassampahController::class, 'getCentimeterData'])->name('get-centimeter-data');

//simpan data popup dari input data
Route::post('/simpan-data', [DataController::class, 'simpanData'])->name('simpan-data');
//tampilkan data dari asil input data popup
Route::get('/tampil-data', [TampilDataController::class, 'tampilData']);
//delete data
Route::post('/delete-data', [DeleteDataController::class, 'deleteData']);
// Menampilkan daftar data ultrasonic
Route::get('/ultrasonic', [UltrasonicController::class, 'index'])->name('ultrasonic.index');

// Menampilkan formulir untuk membuat data ultrasonic baru
Route::get('/ultrasonic/create', [UltrasonicController::class, 'create'])->name('ultrasonic.create');

// Menyimpan data ultrasonic baru
Route::post('/ultrasonic', [UltrasonicController::class, 'store'])->name('ultrasonic.store');

// Menampilkan data ultrasonic tertentu
Route::get('/ultrasonic/{id}', [UltrasonicController::class, 'show'])->name('ultrasonic.show');
// kapasitas sampah
