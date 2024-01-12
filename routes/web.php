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

 Route::group([
    'prefix' => '/AT',
    'middleware' => 'auth',
], function() {
    Route::get('/', function() {
        return redirect('/login');
    });
    
    Route::get('/login', function () {
        if(Auth::check()) {
            return redirect('/dashboard');
        }
        return view('login');
    })->name('login')->withoutMiddleware('auth');
    
    Route::post('/login', [LoginController::class,'authenticate'])->withoutMiddleware('auth');
    
    Route::get('/dashboard', function () {
        Log::info("get user dashboard: ".Auth::user());
        return view('dashboard');
    })->name('dashboard');
});



Route::fallback(function() {
    return view('404');
});
