<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder extends Model
{
    use HasFactory;

    protected $table = 'common_feeder';

    protected $fillable = [
        'comCode',
        'fCode',
        'fName',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'isActive'
    ];

    protected $casts = [
        'comCode' => 'string',
        'fCode' => 'string',
        'fName' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'isActive' => BooleanString::class
    ];
}
