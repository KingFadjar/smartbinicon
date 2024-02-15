<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KorporatController;
use App\Http\Controllers\RetailController;
// use App\Http\Middleware\Role_1;
// use App\Http\Middleware\Role_2;
use App\Http\Middleware\Role_3;
use App\Http\Middleware\Role_4;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/korporat', [KorporatController::class, 'index'])->middleware('auth','role4');
Route::get('/retail', [RetailController::class, 'index'])->middleware('auth','role3');


//auth users
// Route::get('/korporat', [korporatController::class, 'index'])->middleware('Role_1');
// Route::get('/retail', [RetailController::class, 'index'])->middleware('Role_2');
// Route::get('/korporat', [korporatController::class, 'index'])->middleware('Role_4');
// Route::get('/retail', [RetailController::class, 'index'])->middleware('Role_3');

//route search korporate
Route::get('/search', [SearchController::class, 'search']);
Route::post('/search', [SearchController::class, 'search']);
