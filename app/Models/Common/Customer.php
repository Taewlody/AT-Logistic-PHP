<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;
use Carbon\Carbon;

class Customer extends Model implements Wireable
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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? 'C01';
        $this->cusCode = $attributes['cusCode'] ?? '';
        $this->businessType = $attributes['businessType'] ?? '';
        $this->custNameTH = $attributes['custNameTH'] ?? '';
        $this->custNameEN = $attributes['custNameEN'] ?? '';
        $this->branchCode = $attributes['branchCode'] ?? '';
        $this->branchTH = $attributes['branchTH'] ?? '';
        $this->branchEN = $attributes['branchEN'] ?? '';
        $this->creditDay = $attributes['creditDay'] ?? 0;
        $this->taxID = $attributes['taxID'] ?? '';
        $this->salemanID = $attributes['salemanID'] ?? '';
        $this->addressTH = $attributes['addressTH'] ?? '';
        $this->addressEN = $attributes['addressEN'] ?? '';
        $this->zipCode = $attributes['zipCode'] ?? '';
        $this->countryCode = $attributes['countryCode'] ?? '';
        $this->tel = $attributes['tel'] ?? '';
        $this->fax = $attributes['fax'] ?? '';
        $this->mobile = $attributes['mobile'] ?? '';
        $this->isActive = $attributes['isActive'] ?? true;
        $this->contactName = $attributes['contactName'] ?? '';
        $this->contactMobile = $attributes['contactMobile'] ?? '';
        $this->contactEmail = $attributes['contactEmail'] ?? '';
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $cusCode = $value['cusCode'];
        $businessType = $value['businessType'];
        $custNameTH = $value['custNameTH'];
        $custNameEN = $value['custNameEN'];
        $branchCode = $value['branchCode'];
        $branchTH = $value['branchTH'];
        $branchEN = $value['branchEN'];
        $creditDay = $value['creditDay'];
        $taxID = $value['taxID'];
        $salemanID = $value['salemanID'];
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
        return new static(['comCode' => $comCode, 'cusCode' => $cusCode, 'businessType' => $businessType, 'custNameTH' => $custNameTH, 'custNameEN' => $custNameEN, 'branchCode' => $branchCode, 'branchTH' => $branchTH, 'branchEN' => $branchEN, 'creditDay' => $creditDay, 'taxID' => $taxID, 'salemanID' => $salemanID, 'addressTH' => $addressTH, 'addressEN' => $addressEN, 'zipCode' => $zipCode, 'countryCode' => $countryCode, 'tel' => $tel, 'fax' => $fax, 'mobile' => $mobile, 'isActive' => $isActive, 'contactName' => $contactName, 'contactMobile' => $contactMobile, 'contactEmail' => $contactEmail, 'createID' => $createID, 'createTime' => $createTime, 'editID' => $editID, 'editTime' => $editTime]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'cusCode' => $this->cusCode,
            'businessType' => $this->businessType,
            'custNameTH' => $this->custNameTH,
            'custNameEN' => $this->custNameEN,
            'branchCode' => $this->branchCode,
            'branchTH' => $this->branchTH,
            'branchEN' => $this->branchEN,
            'creditDay' => $this->creditDay,
            'taxID' => $this->taxID,
            'salemanID' => $this->salemanID,
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
            'createTime' => $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime
        ];
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'countryCode', 'countryCode');
    }

    public function saleman(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'salemanID');
    }

    public function creditType(): HasOne
    {
        return $this->hasOne(CreditTerm::class, 'creditCode', 'creditDay');
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'createID');
    }
    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'editID');
    }
}
