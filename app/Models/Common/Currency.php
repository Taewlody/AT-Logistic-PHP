<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;

class Currency extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_currency';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'currencyCode';

    protected $dateFormat = 'y-m-d H:i:s';
    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $fillable = [
        'comCode',
        'currencyCode',
        'currencyName',
        'exchange_rate',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'currencyCode' => 'string',
        'currencyName' => 'string',
        'exchange_rate' => 'float',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $this->attributes['comCode'] ?? 'C01';
        $this->currencyCode = $this->attributes['currencyCode'] ?? '';
        $this->currencyName = $this->attributes['currencyName'] ?? '';
        $this->exchange_rate = $this->attributes['exchange_rate'] ?? '';
        $this->isActive = $this->attributes['isActive'] ?? '';
        $this->createID = $this->attributes['createID'] ?? '';
        $this->createTime = $this->attributes['createTime'] ?? '';
        $this->editID = $this->attributes['editID'] ?? '';
        $this->editTime = $this->attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value){
        return new static([
            'comCode' => $value['comCode'],
            'currencyCode' => $value['currencyCode'],
            'currencyName' => $value['currencyName'],
            'exchange_rate' => $value['exchange_rate'],
            'isActive' => $value['isActive'],
            'createID' => $value['createID'],
            'createTime' => $value['createTime'],
            'editID' => $value['editID'],
            'editTime' => $value['editTime'],
        ]);
    }

    public function toLivewire(){
        return [
            'comCode' => $this->comCode,
            'currencyCode' => $this->currencyCode,
            'currencyName' => $this->currencyName,
            'exchange_rate' => $this->exchange_rate,
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
}
