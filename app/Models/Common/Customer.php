<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Casts\BooleanString;
use App\Models\User;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'common_customer';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'cusCode';

    protected $fillable = [
        'comCode',
        'cusCode',
        'businessType',
        'custNameTH',
        'custNameEN',
        'branchCode',
        'branchTH',
        'branchEN',
        'creditDay',
        'taxID',
        'salemanID',
        'addressTH',
        'addressEN',
        'zipCode',
        'countryCode',
        'tel',
        'fax',
        'mobile',
        'isActive',
        'contactName',
        'contactMobile',
        'contactEmail',
        'createID',
        'createTime',
        'editID',
        'editTime'
    ];

    protected $casts = [
        'comCode' => 'string',
        'cusCode' => 'string',
        'businessType' => 'string',
        'custNameTH' => 'string',
        'custNameEN' => 'string',
        'branchCode' => 'string',
        'branchTH' => 'string',
        'branchEN' => 'string',
        'creditDay' => 'integer',
        'taxID' => 'string',
        'salemanID' => 'string',
        'addressTH' => 'string',
        'addressEN' => 'string',
        'zipCode' => 'string',
        'countryCode' => 'string',
        'tel' => 'string',
        'fax' => 'string',
        'mobile' => 'string',
        'isActive' => BooleanString::class,
        'contactName' => 'string',
        'contactMobile' => 'string',
        'contactEmail' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M'
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
