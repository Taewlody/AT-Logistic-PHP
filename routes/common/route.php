<?php
use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Common\Country\Page as Country;
use App\Livewire\Page\Common\Country\Form as CountryForm;
use App\Livewire\Page\Common\Port\Page as Port;
use App\Livewire\Page\Common\Port\Form as PortForm;
use App\Livewire\Page\Common\Customer\Page as Customer;
use App\Livewire\Page\Common\Customer\Form as CustomerForm;
use App\Livewire\Page\Common\Supplier\Page as Supplier;
use App\Livewire\Page\Common\Supplier\Form as SupplierForm;
use App\Livewire\Page\Common\Saleman\Page as Saleman;
use App\Livewire\Page\Common\Saleman\Form as SalemanForm;
use App\Livewire\Page\Common\Feeder\Page as Feeder;
use App\Livewire\Page\Common\Feeder\Form as FeederForm;
use App\Livewire\Page\Common\Charges\Page as Charge;
use App\Livewire\Page\Common\Charges\Form as ChargeForm;
use App\Livewire\Page\Common\BankAccount\Page as BankAccount;
use App\Livewire\Page\Common\BankAccount\Form as BankAccountForm;
use App\Livewire\Page\Common\ChargesType\Page as ChargeType;
use App\Livewire\Page\Common\ChargesType\Form as ChargeTypeForm;
use App\Livewire\Page\Common\TransportType\Page as TransportType;
use App\Livewire\Page\Common\TransportType\Form as TransportTypeForm;
use App\Livewire\Page\Common\ContainerType\Page as ContainerType;
use App\Livewire\Page\Common\ContainerType\Form as ContainerTypeForm;
use App\Livewire\Page\Common\ContainerSize\Page as ContainerSize;
use App\Livewire\Page\Common\ContainerSize\Form as ContainerSizeForm;
use App\Livewire\Page\Common\Place\Page as Place;
use App\Livewire\Page\Common\Place\Form as PlaceForm;
use App\Livewire\Page\Common\Unit\Page as Unit;
use App\Livewire\Page\Common\Unit\Form as UnitForm;
use App\Livewire\Page\Common\Currency\Page as Currency;
use App\Livewire\Page\Common\Currency\Form as CurrencyForm;
use App\Livewire\Page\Common\Company\Page as Company;
use App\Livewire\Page\Common\Company\Form as CompanyForm;
use App\Livewire\Page\Common\Commodity\Page as Commodity;
use App\Livewire\Page\Common\Commodity\Form as CommodityForm;

Route::group(['prefix' => '/common',], function() {

    Route::get('/country', Country::class)->name('country');
    
    Route::get('/country/form', CountryForm::class)->name('country.form');

    Route::get('/port', Port::class)->name('port');

    Route::get('/port/form', PortForm::class)->name('port.form');

    Route::get('/customer', Customer::class)->name('customer');

    Route::get('/customer/form', CustomerForm::class)->name('customer.form');

    Route::get('/supplier', Supplier::class)->name('supplier');

    Route::get('/supplier/form', SupplierForm::class)->name('supplier.form');

    Route::get('/saleman', Saleman::class)->name('saleman');

    Route::get('/saleman/form', SalemanForm::class)->name('saleman.form');

    Route::get('/feeder', Feeder::class)->name('feeder');

    Route::get('/feeder/form', FeederForm::class)->name('feeder.form');

    Route::get('/charges', Charge::class)->name('charges');

    Route::get('/charges/form', ChargeForm::class)->name('charges.form');

    Route::get('/bank-account', BankAccount::class)->name('bank-account');

    Route::get('/bank-account/form', BankAccountForm::class)->name('bank-account.form');

    Route::get('/charges-type', ChargeType::class)->name('charges-type');

    Route::get('/charges-type/form', ChargeTypeForm::class)->name('charges-type.form');

    Route::get('/transport-type', TransportType::class)->name('transport-type');

    Route::get('/transport-type/form', TransportTypeForm::class)->name('transport-type.form');

    Route::get('/container-type', ContainerType::class)->name('container-type');

    Route::get('/container-type/form', ContainerTypeForm::class)->name('container-type.form');

    Route::get('/container-size', ContainerSize::class)->name('container-size');

    Route::get('/container-size/form', ContainerSizeForm::class)->name('container-size.form');

    Route::get('/place', Place::class)->name('place');

    Route::get('/place/form', PlaceForm::class)->name('place.form');

    Route::get('/unit', Unit::class)->name('unit');

    Route::get('/unit/form', UnitForm::class)->name('unit.form');

    Route::get('/currency', Currency::class)->name('currency');

    Route::get('/currency/form', CurrencyForm::class)->name('currency.form');

    Route::get('/company', CompanyForm::class)->name('company');

    Route::get('/commodity', Commodity::class)->name('commodity');

    Route::get('/commodity/form', CommodityForm::class)->name('commodity.form');
});
