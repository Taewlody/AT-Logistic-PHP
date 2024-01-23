<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class DepositAttach extends Model
{
    use HasFactory;

    protected $table = 'deposit_attach';

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
