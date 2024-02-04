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
use App\Livewire\Page\Common\Country\Form as CountryForm;
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
use App\Livewire\Page\Customer\AdvancePayment\Page as AdvancePayment;
use App\Livewire\Page\Shipping\PaymentVoucher\Page as PaymentVoucherShipping;
use App\Livewire\Page\Shipping\PettyCash\Page as PettyCashShipping;
use App\Livewire\Page\Shipping\Deposit\Page as Deposit;
use App\Livewire\Page\Messenger\CalendarBooking\Page as CalendarBooking;
use App\Livewire\Page\Messenger\MessengerBooking\Page as MessengerBooking;
use App\Livewire\Page\Account\Invoice\Page as Invoice;
use App\Livewire\Page\Account\TaxInvoice\Page as TaxInvoice;
use App\Livewire\Page\Account\PaymentVoucher\Page as PaymentVoucherAccount;
use App\Livewire\Page\Account\ReceiptVoucher\Page as ReceiptVoucher;
use App\Livewire\Page\Account\BillingReceipt\Page as BillingReceipt;
use App\Livewire\Page\Account\PettyCash\Page as PettyCashAccount;
use App\Livewire\Page\Account\WithholdingTax\Page as WithholdingTax;
use App\Livewire\Page\Report\ReportJob\Page as ReportJob;
use App\Livewire\Page\Report\ReportProfitAndLossJob\Page as ReportProfitAndLossJob;
use App\Livewire\Page\Report\ReportSaleInvoice\Page as ReportSaleInvoice;
use App\Livewire\Page\Report\ReportSaleTaxInvoice\Page as ReportSaleTaxInvoice;
use App\Livewire\Page\Report\ReportInvoiceOverdue\Page as ReportInvoiceOverdue;
use App\Livewire\Page\Report\PaymentVoucherItems\Page as ReportPaymentVoucherItems;
use App\Livewire\Page\Report\ReceiptVoucher\Page as ReportReceiptVoucher;
use App\Livewire\Page\Report\TaxInvoice\Page as ReportTaxInvoice;
use App\Livewire\Page\Report\PaymentVoucher\Page as ReportPaymentVoucher;
use App\Livewire\Page\Administrator\User\Page as Users;
use App\Livewire\Page\Administrator\UserType\Page as UserType;

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

    Route::group(['prefix' => '/common',], function() {

        Route::get('/country', Country::class)->name('country');
        
        Route::get('/country/form', CountryForm::class)->name('country.form');

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
    });
    
    Route::group(['prefix' => '/marketing',], function() {
        Route::get('/job-order', JobOrder::class)->name('job-order');

        Route::get('/trailer-booking', TrailerBooking::class)->name('trailer-booking');
    
        Route::get('/bill-of-lading', BillOfLading::class)->name('bill-of-lading');
    });

    Route::group(['prefix' => '/customer',], function() {
        Route::get('/advance-payment', AdvancePayment::class)->name('advance-payment');
    });

    Route::group(['prefix'=> 'shipping',], function() {
        Route::get('/payment-voucher', PaymentVoucherShipping::class)->name('shipping-payment-voucher');

        Route::get('/petty-cash', PettyCashShipping::class)->name('shipping-petty-cash');

        Route::get('/deposit', Deposit::class)->name('deposit');
    });
    
    Route::group(['prefix'=> 'messenger',], function() {
        Route::get("/calendar-booking", CalendarBooking::class)->name('calendar-booking');

        Route::get("/messanger-booking", MessengerBooking::class)->name('messanger-booking');
    });

    Route::group(['prefix'=> 'account',], function() {
        Route::get("/invoice", Invoice::class)->name('invoice')
        ;
        Route::get("/tax-invoice", TaxInvoice::class)->name('tax-invoice');

        Route::get("/payment-voucher", PaymentVoucherAccount::class)->name('account-payment-voucher');

        Route::get("/receipt-voucher", ReceiptVoucher::class)->name('receipt-voucher');

        Route::get("/billing-receipt", BillingReceipt::class)->name('billing-receipt');

        Route::get("/petty-cash", PettyCashAccount::class)->name('account-petty-cash');

        Route::get("/withholding-tax", WithholdingTax::class)->name('withholding-tax');
    });

    Route::group(['prefix'=> 'report',], function() {
        Route::get("/report-job", ReportJob::class)->name('report-job');

        Route::get("/report-profit-and-loss-job", ReportProfitAndLossJob::class)->name('report-profit-and-loss-job');

        Route::get("/report-sale-invoice", ReportSaleInvoice::class)->name('report-sale-invoice');

        Route::get("/report-sale-tax-invoice", ReportSaleTaxInvoice::class)->name('report-sale-tax-invoice');

        Route::get("/report-invoice-overdue", ReportInvoiceOverdue::class)->name('report-invoice-overdue');

        Route::get("/report-payment-voucher-items", ReportPaymentVoucherItems::class)->name('report-payment-voucher-items');

        Route::get("/report-receipt-voucher", ReportReceiptVoucher::class)->name('report-receipt-voucher');

        Route::get("/report-tax-invoice", ReportTaxInvoice::class)->name('report-tax-invoice');

        Route::get("/report-payment-voucher", ReportPaymentVoucher::class)->name('report-payment-voucher');
    });

    Route::group(['prefix'=> 'administrator',], function() {
        Route::get("/users", Users::class)->name('user');

        Route::get("/user-type", UserType::class)->name('user-type');
    });

});



Route::fallback(function() {
    return view('404');
});
