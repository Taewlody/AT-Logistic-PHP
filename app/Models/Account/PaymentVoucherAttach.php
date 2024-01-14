<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucherAttach extends Model
{
    use HasFactory;

    protected $table = 'payment_voucher_attach';

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'supCode',
        'fileDetail',
        'fileName',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'supCode' => 'string',
        'fileDetail' => 'string',
        'fileName' => 'string',
    ];
}
