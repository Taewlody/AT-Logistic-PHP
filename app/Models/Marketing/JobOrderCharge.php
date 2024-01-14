<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderCharge extends Model
{
    use HasFactory;

    protected $table = 'joborder_charge';

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'ref_paymentCode',
        'chargeCode',
        'detail',
        'chargesCost',
        'chargesReceive',
        'chargesbillReceive',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'ref_paymentCode' => 'string',
        'chargeCode' => 'string',
        'detail' => 'string',
        'chargesCost' => 'float',
        'chargesReceive' => 'float',
        'chargesbillReceive' => 'float',
    ];
}
