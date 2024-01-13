<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;

    protected $table = 'common_charge';

    protected $fillable = [
        'comCode',
        'chargeCode',
        'chargeName',
        'typeCode',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'purchaseVat',
    ];

    protected $casts = [
        'comCode' => 'string',
        'chargeCode' => 'string',
        'chargeName' => 'string',
        'typeCode' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'purchaseVat' => 'string',
    ];
}
