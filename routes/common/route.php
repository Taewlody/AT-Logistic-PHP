<?php
use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Common\Country\Page as Country;
use App\Livewire\Page\Common\Country\Form as CountryForm;
use App\Livewire\Page\Common\Port\Page as Port;
use App\Livewire\Page\Common\Port\Form as PortForm;
use App\Livewire\Page\Common\Customer\Page as Customer;
use App\Livewire\Page\Common\Customer\Form as CustomerForm;
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

Route::group(['prefix' => '/common',], function() {

    Route::get('/country', Country::class)->name('country');
    
    Route::get('/country/form', CountryForm::class)->name('country.form');

    Route::get('/port', Port::class)->name('port');

    Route::get('/port/form', PortForm::class)->name('port.form');

    Route::get('/customer', Customer::class)->name('customer');

    Route::get('/customer/form', CustomerForm::class)->name('customer.form');

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
});
