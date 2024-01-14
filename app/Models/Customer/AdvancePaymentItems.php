<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvancePaymentItems extends Model
{
    use HasFactory;

    protected $table = 'advance_payment_items';

    protected $fillable = [
        'autoid',
        'comCode',
        'documentID',
        'invNo',
        'chargeCode',
        'chartDetail',
        'amount'
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'invNo' => 'string',
        'chargeCode' => 'string',
        'chartDetail' => 'string',
        'amount' => 'float',
    ];
}
