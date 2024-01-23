<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class PaymentVoucherAttach extends Model
{
    use HasFactory;

    protected $table = 'payment_voucher_attach';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

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
