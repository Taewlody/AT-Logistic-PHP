<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class TaxInvoiceItems extends Model
{
    use HasFactory; 

    protected $table = 'tax_invoice_items';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    protected $fillable = [
        'items',
        'comCode',
        'invNo',
        'documentID',
        'chargeCode',
        'detail',
        'chargesCost',
        'chargesReceive',
        'chargesbillReceive',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'invNo' => 'string',
        'documentID' => 'string',
        'chargeCode' => 'string',
        'detail' => 'string',
        'chargesCost' => 'float',
        'chargesReceive' => 'float',
        'chargesbillReceive' => 'float',
    ];
}
