<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;

class CreditTerm extends Model
{
    use HasFactory;

    protected $table = 'common_creditterm';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'creditCode';
    
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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];
}
