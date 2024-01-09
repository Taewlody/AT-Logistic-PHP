<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('login');
});

Route::post('/', [LoginController::class,'authenticate']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::fallback(function() {
    return view('404');
});
