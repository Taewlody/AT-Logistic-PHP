<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $table = 'deposit';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'refJobNo',
        'agentCode',
        'cusCode',
        'payType',
        'payTypeOther',
        'branch',
        'chequeNo',
        'dueDate',
        'note',
        'remark',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'sumTotal',
        'accountCode',
        'dueTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => 'date: Y-m-d',
        'refJobNo' => 'string',
        'agentCode' => 'string',
        'cusCode' => 'string',
        'payType' => 'string',
        'payTypeOther' => 'string',
        'branch' => 'string',
        'chequeNo' => 'string',
        'dueDate' => 'date: Y-m-d',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'sumTotal' => 'float',
        'accountCode' => 'string',
        'dueTime' => 'time: H:M',
    ];
}
