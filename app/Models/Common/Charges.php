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
        $this->fill($attributes);
    }

    public static function fromLivewire($value)
    {
        return new static($value);
    }

    public function toLivewire()
    {
        return $this->toArray();
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
