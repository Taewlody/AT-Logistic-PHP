<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saleman extends Model
{
    use HasFactory;

    protected $table = 'common_saleman';

    protected $fillable = [
        'comCode',
        'empCode',
        'empName',
        'empSurname',
        'usercode',
        'mobile',
        'phone',
        'email',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'isActive'
    ];

    protected $casts = [
        'comCode' => 'string',
        'empCode' => 'string',
        'empName' => 'string',
        'empSurname' => 'string',
        'usercode' => 'string',
        'mobile' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'isActive' => BooleanString::class
    ];
}
