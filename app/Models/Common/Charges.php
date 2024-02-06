<?php

namespace App\Models\Common;

use App\Casts\BooleanStringChar;
use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use App\Models\Common\ChargesType;
use Livewire\Wireable;
use Carbon\Carbon;

class Charges extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_charge';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'chargeCode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $attributes = [
        'comCode' => 'C01',
        'isActive' => false,
    ];

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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'purchaseVat' => BooleanStringChar::class,
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? '';
        $this->chargeCode = $attributes['chargeCode'] ?? '';
        $this->chargeName = $attributes['chargeName'] ?? '';
        $this->typeCode = $attributes['typeCode'] ?? '';
        $this->isActive = $attributes['isActive'] ?? '';
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
        $this->purchaseVat = $attributes['purchaseVat'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $chargeCode = $value['chargeCode'];
        $chargeName = $value['chargeName'];
        $typeCode = $value['typeCode'];
        $isActive = $value['isActive'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        $purchaseVat = $value['purchaseVat'];
        return new static([
            'comCode' => $comCode,
            'chargeCode' => $chargeCode,
            'chargeName' => $chargeName,
            'typeCode' => $typeCode,
            'isActive' => $isActive,
            'createID' => $createID,
            'createTime' => $createTime,
            'editID' => $editID,
            'editTime' => $editTime,
            'purchaseVat' => $purchaseVat,
        ]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'chargeCode' => $this->chargeCode,
            'chargeName' => $this->chargeName,
            'typeCode' => $this->typeCode,
            'isActive' => $this->isActive,
            'createID' => $this->createID,
            'createTime' => $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime,
            'purchaseVat' => $this->purchaseVat,
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

    public function chargesType(): HasOne
    {
        return $this->hasOne(ChargesType::class, 'typeCode','typeCode');
    }
}
