<?php

use App\Http\Resources\BlobFileResource;
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
    Route::get('/blobfile/{filename}', [BlobFileResource::class, 'viewFile']);

    Route::post('/blobfile/add', [BlobFileResource::class, 'addFile']);

    Route::get('print/advance_payment_pdf/{documentID}', [PrintFileResource::class, 'AdvancePaymentPdf']);

    Route::get('print/advance_payment_pdf/{documentID}/download', [PrintFileResource::class, 'AdvancePaymentPdfDownload']);
});

