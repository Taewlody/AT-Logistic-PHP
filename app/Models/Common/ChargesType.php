<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargesType extends Model
{
    use HasFactory;

    protected $table = 'common_chargestype';

    protected $fillable = [
        'comCode',
        'typeCode',
        'typeName',
        'vatType',
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
        'vatType' => 'string',
        'amount' => 'float',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];
}
