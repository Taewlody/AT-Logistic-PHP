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
