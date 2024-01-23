<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'common_supplier';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'supCode';

    protected $fillable = [
        'comCode',
        'supCode',
        'businessType',
        'supNameTH',
        'supNameEN',
        'branchCode',
        'branchTH',
        'branchEN',
        'taxID',
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
        'editTime',
        'supType'
    ];

    protected $casts = [
        'comCode' => 'string',
        'supCode' => 'string',
        'businessType' => 'string',
        'supNameTH' => 'string',
        'supNameEN' => 'string',
        'branchCode' => 'string',
        'branchTH' => 'string',
        'branchEN' => 'string',
        'taxID' => 'string',
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
        'editTime' => 'datetime:Y-m-d H:M',
        'supType' => 'string'
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
