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
use App\Livewire\Page\Common\Country\Page as Country;
use App\Livewire\Page\Common\Port\Page as Port;
use App\Livewire\Page\Common\Customer\Page as Customer;
use App\Livewire\Page\Common\Supplier\Page as Supplier;
use App\Livewire\Page\Common\Saleman\Page as Saleman;
use App\Livewire\Page\Common\Feeder\Page as Feeder;
use App\Livewire\Page\Common\Charges\Page as Charge;
use App\Livewire\Page\Common\BankAccount\Page as BankAccount;
use App\Livewire\Page\Common\ChargesType\Page as ChargeType;
use App\Livewire\Page\Common\TransportType\Page as TransportType;
use App\Livewire\Page\Common\ContainerType\Page as ContainerType;
use App\Livewire\Page\Common\ContainerSize\Page as ContainerSize;
use App\Livewire\Page\Common\Place\Page as Place;
use App\Livewire\Page\Common\Unit\Page as Unit;
use App\Livewire\Page\Common\Currency\Page as Currency;
use App\Livewire\Page\Marketing\JobOrder\Page as JobOrder;
use App\Livewire\Page\Marketing\TrailerBooking\Page as TrailerBooking;
use App\Livewire\Page\Marketing\BillOfLading\Page as BillOfLading;

 Route::group([
    'prefix' => '/AT',
    'middleware' => ['auth', 'auth.session', 'session.timeout',]
], function() {
    Route::get('/', function() {
        return redirect('/login');
    });
    
    Route::get('/login', function () {
        return view('login');
    })->name('login')->withoutMiddleware(['auth', 'auth.session', 'session.timeout'])->Middleware('guest');
    
    Route::post('/login', [AuthController::class,'authenticate'])->withoutMiddleware(['auth', 'auth.session', 'session.timeout'])->Middleware('guest');

    // Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/country', Country::class)->name('country');

    Route::get('/port', Port::class)->name('port');

    Route::get('/customer', Customer::class)->name('customer');

    Route::get('/supplier', Supplier::class)->name('supplier');

    Route::get('/saleman', Saleman::class)->name('saleman');

    Route::get('/feeder', Feeder::class)->name('feeder');

    Route::get('/charges', Charge::class)->name('charges');

    Route::get('/bank-account', BankAccount::class)->name('bank-account');

    Route::get('/charges-type', ChargeType::class)->name('charges-type');

    Route::get('/transport-type', TransportType::class)->name('transport-type');

    Route::get('/container-type', ContainerType::class)->name('container-type');

    Route::get('/container-size', ContainerSize::class)->name('container-size');

    Route::get('/place', Place::class)->name('place');

    Route::get('/unit', Unit::class)->name('unit');

    Route::get('/currency', Currency::class)->name('currency');

    Route::get('/job-order', JobOrder::class)->name('job-order');

    Route::get('/trailer-booking', TrailerBooking::class)->name('trailer-booking');

    Route::get('/bill-of-lading', BillOfLading::class)->name('bill-of-lading');

});



Route::fallback(function() {
    return view('404');
});
