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

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

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
        'usercode',
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
        'usercode' => 'string',
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class
    ];

    protected $attributes = [
        'comCode' => 'C01',
        'isActive' => false,
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
        $this->exists = $attributes['exists'] ?? false;
        $this->setConnection($attributes['connection'] ?? 'mysql');
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->cusCode = self::genarateKey();
        });
    }

    public static function genarateKey(){
        $prefix = "C";
        $cusCodes = self::pluck('cusCode');
        
        $maxNumber = 0;

        foreach ($cusCodes as $cusCode) {
            $numericPart = (int) substr($cusCode, strlen($prefix) + 1); 
            if ($numericPart > $maxNumber) {
                $maxNumber = $numericPart;
            }
        }
        $newNumber = $maxNumber + 1;
        $index = str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        
        return $prefix.'-'.$index;
    }

    public static function fromLivewire($value): self
    {
        return new static($value);
    }

    public function toLiveWire() : array
    {
        // return $this->toArray();
        $arr = $this->toArray();
        $arr['exists'] = $this->exists;
        $arr['connection'] = $this->getConnectionName();
        return $arr;
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

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'usercode');
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
