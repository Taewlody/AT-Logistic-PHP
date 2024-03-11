<?php

namespace App\Models\Common;

use App\Casts\BooleanStringChar;
use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->chargeCode = self::genarateKey();
        });
    }

    public static function genarateKey(){
        $prefix = "C";
        $lastKey = self::where(self::getKeyName(), 'LIKE', $prefix.'%')->max(self::getKeyName());
        if($lastKey != null){
            $lastKey = intval(explode('-', $lastKey)[1]) + 1;
        }else{
            $lastKey = 1;
        }
        $index = str_pad($lastKey, 3, '0', STR_PAD_LEFT);
        return $prefix.'-'.$index;
    }

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
