<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatType extends Model
{
    use HasFactory;

    protected $table = 'common_vattype';

    protected $fillable = [
        'comCode',
        'typeCode',
        'typeName',
        'amount',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'typeCode' => 'string',
        'typeName' => 'string',
        'amount' => 'float',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];
}
