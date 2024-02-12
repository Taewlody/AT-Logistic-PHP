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
use App\Livewire\Page\Dashboard\Page as Dashboard;

use App\Livewire\Page\Test;

 Route::group([
    'prefix' => '/AT',
    'middleware' => ['auth', 'auth.session', 'session.timeout',]
], function() {
    Route::get('/', function() {
        return redirect('/login');
    });

    Route::get('/test', Test::class)->name('test');
    
    Route::get('/login', function () {
        return view('login');
    })->name('login')->withoutMiddleware(['auth', 'auth.session', 'session.timeout'])->Middleware('guest');
    
    Route::post('/login', [AuthController::class,'authenticate'])->withoutMiddleware(['auth', 'auth.session', 'session.timeout'])->Middleware('guest');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get("/dashboard", Dashboard::class)->name('dashboard');

    require_once(__DIR__.'/common/route.php');
    
    require_once(__DIR__.'/marketing/route.php');

    require_once(__DIR__.'/customer/route.php');

    require_once(__DIR__.'/shipping/route.php');

    require_once(__DIR__.'/messenger/route.php');

    require_once(__DIR__.'/account/route.php');

    require_once(__DIR__.'/report/route.php');

    require_once(__DIR__.'/administrator/route.php');

});



Route::fallback(function() {
    return view('404');
});
