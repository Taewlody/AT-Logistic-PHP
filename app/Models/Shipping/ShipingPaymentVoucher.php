<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class ShipingPaymentVoucher extends Model
{
    use HasFactory;

    protected $table = 'shiping_payment_voucher';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'refJobNo',
        'supCode',
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
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => 'date: Y-m-d',
        'refJobNo' => 'string',
        'supCode' => 'string',
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
    ];
}
