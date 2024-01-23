<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;

class VatType extends Model
{
    use HasFactory;

    protected $table = 'common_vattype';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'typeCode';
    
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
