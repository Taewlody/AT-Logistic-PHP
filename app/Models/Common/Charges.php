<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use App\Models\Common\ChargesType;

class Charges extends Model
{
    use HasFactory;

    protected $table = 'common_charge';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'chargeCode';

    protected $fillable = [
        'comCode',
        'chargeCode',
        'chargeName',
        'typeCode',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'purchaseVat',
    ];

    protected $casts = [
        'comCode' => 'string',
        'chargeCode' => 'string',
        'chargeName' => 'string',
        'typeCode' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'purchaseVat' => 'string',
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }

    public function chargesType(): HasOne
    {
        return $this->hasOne(ChargesType::class, 'typeCode','typeCode');
    }
}
