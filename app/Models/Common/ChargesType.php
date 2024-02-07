<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;

class ChargesType extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_chargestype';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'typeCode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $fillable = [
        'comCode',
        'typeCode',
        'typeName',
        'vatType',
        'amount',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'typeCode' => 'string',
        'typeName' => 'string',
        'vatType' => 'string',
        'amount' => 'float',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->comCode = $this->attributes['comCode'] ?? 'C01';
        $this->typeCode = $this->attributes['typeCode'] ?? '';
        $this->typeName = $this->attributes['typeName'] ?? '';
        $this->vatType = $this->attributes['vatType'] ?? '';
        $this->amount = $this->attributes['amount'] ?? '';
        $this->isActive = $this->attributes['isActive'] ?? '';
        $this->createID = $this->attributes['createID'] ?? '';
        $this->createTime = $this->attributes['createTime'] ?? '';
        $this->editID = $this->attributes['editID'] ?? '';
        $this->editTime = $this->attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'] ?? '';
        $typeCode = $value['typeCode'] ?? '';
        $typeName = $value['typeName'] ?? '';
        $vatType = $value['vatType'] ?? '';
        $amount = $value['amount'] ?? '';
        $isActive = $value['isActive'] ?? '';
        $createID = $value['createID'] ?? '';
        $createTime = $value['createTime'] ?? '';
        $editID = $value['editID'] ?? '';
        $editTime = $value['editTime'] ?? '';
        return new static([
            'comCode' => $comCode,
            'typeCode' => $typeCode,
            'typeName' => $typeName,
            'vatType' => $vatType,
            'amount' => $amount,
            'isActive' => $isActive,
            'createID' => $createID,
            'createTime' => $createTime,
            'editID' => $editID,
            'editTime' => $editTime,
        ]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'typeCode' => $this->typeCode,
            'typeName' => $this->typeName,
            'vatType' => $this->vatType,
            'amount' => $this->amount,
            'isActive' => $this->isActive,
            'createID' => $this->createID,
            'createTime' => $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime,
        ];
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }

    public function vat(): HasOne
    {
        return $this->hasOne(VatType::class,'typeCode','vatType');
    }
}
