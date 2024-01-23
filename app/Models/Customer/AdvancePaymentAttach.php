<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class AdvancePaymentAttach extends Model
{
    use HasFactory;

    protected $table = 'advance_payment_attach';

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'cusCode',
        'fileDetail',
        'fileName',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'cusCode' => 'string',
        'fileDetail' => 'string',
        'fileName' => 'string',
    ];
}
