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

use App\Http\Controllers\AuthController;

 Route::group([
    'prefix' => '/AT',
    'middleware' => 'auth',
    'middleware' => 'auth.session',
    'middleware' => 'session.timeout',
], function() {
    Route::get('/', function() {
        return redirect('/login');
    });
    
    Route::get('/login', function () {
        // if(Auth::check()) {
        //     return redirect()->route('dashboard');
        // }
        Artisan::call('cache:clear');
        return view('login');
    })->name('login')->withoutMiddleware(['auth', 'auth.session', 'session.timeout'])->Middleware('guest');
    
    Route::post('/login', [AuthController::class,'authenticate'])->withoutMiddleware(['auth', 'auth.session', 'session.timeout'])->Middleware('guest');

    // Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        Log::info("get user dashboard: ".Auth::user());
        return view('dashboard');
    })->name('dashboard');
});



Route::fallback(function() {
    return view('404');
});
