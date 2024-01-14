<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucherItems extends Model
{
    use HasFactory;

    protected $table = 'payment_voucher_items';

    protected $fillable = [
        'autoid',
        'comCode',
        'documentID',
        'invNo',
        'chargeCode',
        'chartDetail',
        'amount',
        'tax',
        'taxamount',
        'vat',
        'vatamount',
    ];

    protected $casts = [
        'autoid' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'invNo' => 'string',
        'chargeCode' => 'string',
        'chartDetail' => 'string',
        'amount' => 'float',
        'tax' => 'integer',
        'taxamount' => 'float',
        'vat' => 'integer',
        'vatamount' => 'float',
    ];
}
