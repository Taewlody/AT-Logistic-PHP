<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditTerm extends Model
{
    use HasFactory;

    protected $table = 'common_creditterm';

    protected $fillable = [
        'comCode',
        'creditCode',
        'creditName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'creditCode' => 'integer',
        'creditName' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];
}
