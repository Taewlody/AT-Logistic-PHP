<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositItems extends Model
{
    use HasFactory;

    protected $table = 'deposit_items';

    protected $fillable = [
        'autoid',
        'comCode',
        'documentID',
        'invNo',
        'chargeCode',
        'chartDetail',
        'amount',
    ];

    protected $casts = [
        'autoid' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'invNo' => 'string',
        'chargeCode' => 'string',
        'chartDetail' => 'string',
        'amount' => 'float',
    ];
}
