<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class ChargesType extends Model
{
    use HasFactory;

    protected $table = 'common_chargestype';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'typeCode';

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
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }

    public function vat(): HasOne
    {
        return $this->hasOne(VatType::class,'typeCode','vatType');
    }
}
