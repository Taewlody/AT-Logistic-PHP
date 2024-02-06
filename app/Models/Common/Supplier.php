<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;
use Carbon\Carbon;

class Supplier extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_supplier';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'supCode';

    public $timestamps = false;
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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'supType' => 'string'
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? 'C01';
        $this->supCode = $attributes['supCode'] ?? '';
        $this->businessType = $attributes['businessType'] ?? '';
        $this->supNameTH = $attributes['supNameTH'] ?? '';
        $this->supNameEN = $attributes['supNameEN'] ?? '';
        $this->branchCode = $attributes['branchCode'] ?? '';
        $this->branchTH = $attributes['branchTH'] ?? '';
        $this->branchEN = $attributes['branchEN'] ?? '';
        $this->taxID = $attributes['taxID'] ?? '';
        $this->addressTH = $attributes['addressTH'] ?? '';
        $this->addressEN = $attributes['addressEN'] ?? '';
        $this->zipCode = $attributes['zipCode'] ?? '';
        $this->countryCode = $attributes['countryCode'] ?? '';
        $this->tel = $attributes['tel'] ?? '';
        $this->fax = $attributes['fax'] ?? '';
        $this->mobile = $attributes['mobile'] ?? '';
        $this->isActive = $attributes['isActive'] ?? false;
        $this->contactName = $attributes['contactName'] ?? '';
        $this->contactMobile = $attributes['contactMobile'] ?? '';
        $this->contactEmail = $attributes['contactEmail'] ?? '';
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
        $this->supType = $attributes['supType'] ?? 'AG';
    }

    public static function fromLivewire($value) {
        $comCode = $value['comCode'];
        $supCode = $value['supCode'];
        $businessType = $value['businessType'];
        $supNameTH = $value['supNameTH'];
        $supNameEN = $value['supNameEN'];
        $branchCode = $value['branchCode'];
        $branchTH = $value['branchTH'];
        $branchEN = $value['branchEN'];
        $taxID = $value['taxID'];
        $addressTH = $value['addressTH'];
        $addressEN = $value['addressEN'];
        $zipCode = $value['zipCode'];
        $countryCode = $value['countryCode'];
        $tel = $value['tel'];
        $fax = $value['fax'];
        $mobile = $value['mobile'];
        $isActive = $value['isActive'];
        $contactName = $value['contactName'];
        $contactMobile = $value['contactMobile'];
        $contactEmail = $value['contactEmail'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        $supType = $value['supType'];
        return new static(['comCode' => $comCode, 'supCode' => $supCode, 'businessType' => $businessType, 'supNameTH' => $supNameTH, 'supNameEN' => $supNameEN, 'branchCode' => $branchCode, 'branchTH' => $branchTH, 'branchEN' => $branchEN, 'taxID' => $taxID, 'addressTH' => $addressTH, 'addressEN' => $addressEN, 'zipCode' => $zipCode, 'countryCode' => $countryCode, 'tel' => $tel, 'fax' => $fax, 'mobile' => $mobile, 'isActive' => $isActive, 'contactName' => $contactName, 'contactMobile' => $contactMobile, 'contactEmail' => $contactEmail, 'createID' => $createID, 'createTime' => $createTime, 'editID' => $editID, 'editTime' => $editTime, 'supType' => $supType]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'supCode' => $this->supCode,
            'businessType' => $this->businessType,
            'supNameTH' => $this->supNameTH,
            'supNameEN' => $this->supNameEN,
            'branchCode' => $this->branchCode,
            'branchTH' => $this->branchTH,
            'branchEN' => $this->branchEN,
            'taxID' => $this->taxID,
            'addressTH' => $this->addressTH,
            'addressEN' => $this->addressEN,
            'zipCode' => $this->zipCode,
            'countryCode' => $this->countryCode,
            'tel' => $this->tel,
            'fax' => $this->fax,
            'mobile' => $this->mobile,
            'isActive' => $this->isActive,
            'contactName' => $this->contactName,
            'contactMobile' => $this->contactMobile,
            'contactEmail' => $this->contactEmail,
            'createID' => $this->createID,
            'createTime' =>  $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime,
            'supType' => $this->supType
        ];
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'countryCode','countryCode');
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
