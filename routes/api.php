<?php

use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Resources\BlobFileResource;
use App\Models\AttachFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\PrintFileResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/tokens/create', function (Request $request) {
//     $token = $request->user()->createToken($request->token_name);
//     return ['token' => $token->plainTextToken];
// });

Route::group(['middleware' => ['auth.basic:,usercode']], function () {
    
    Route::post('/tokens/create', function (Request $request) {
        $token = $request->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    });

    Route::get('/blobfile/filename', function () {
        return AttachFile::select('filename')->get()->map(function ($file) {
            return $file->filename;
        })->toArray();
    });

    Route::get('/blobfile/{filename}', [BlobFileResource::class, 'viewFile']);

    Route::post('/blobfile/add', [BlobFileResource::class, 'addFile']);

});

Route::group(['middleware' => ['web']], function () {

   
    Route::get('print/advance_payment_pdf/{documentID}', [PrintFileResource::class, 'AdvancePaymentPdf']);

    // Route::get('print/advance_payment_pdf/{documentID}/download', [PrintFileResource::class, 'AdvancePaymentPdfDownload']);

    Route::get('print/job_order_pdf/{documentID}', [PrintFileResource::class, 'JobOrderPdf']);

    Route::get('print/booking_job_pdf/{documentID}', [PrintFileResource::class,'BookingJobOrderPdf']);

    Route::get('print/trailer_booking_pdf/{documentID}', [PrintFileResource::class, 'TrailerBookingPdf']);

    Route::get('print/bill_of_lading_pdf/{documentID}', [PrintFileResource::class, 'BillOfLadingPdf']);

    Route::get('print/invoice_pdf/{documentID}', [PrintFileResource::class, 'InvoicePdf']);

    Route::get('print/deposit_pdf/{documentID}', [PrintFileResource::class, 'DepositPdf']);

    Route::get('print/payment_voucher_pdf/{documentID}', [PrintFileResource::class, 'PaymentVoucherPdf']);

    Route::get('print/petty_cash_pdf/{documentID}', [PrintFileResource::class, 'PettyCashPdf']);

    Route::get('print/shipping_payment_voucher_pdf/{documentID}', [PrintFileResource::class, 'ShippingPaymentVoucherPdf']);

    Route::get('print/shipping_petty_cash_pdf/{documentID}', [PrintFileResource::class, 'ShippingPettyCashPdf']);

    Route::get('print/receipt_voucher_pdf/{documentID}', [PrintFileResource::class, 'ReceiptVoucherPdf']);

    Route::get('print/tax_invoice_pdf/{documentID}', [PrintFileResource::class, 'TaxInvoicePdf']);

    Route::get('testview/pdf/{id}', [PrintFileResource::class, 'testViewPdf']);
});

