<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use App\Models\Common\Country;
use Livewire\Wireable;
use Carbon\Carbon;
use App\Casts\CustomDateTime;

class Port extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_port';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'portCode';

    public $timestamps = false;

    protected $fillable = [
        'comCode',
        'portCode',
        'portNameTH',
        'portNameEN',
        'countryCode',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime'
    ];

    protected $casts = [
        'comCode' => 'string',
        'portCode' => 'string',
        'portNameTH' => 'string',
        'portNameEN' => 'string',
        'countryCode'=> 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? 'C01';
        $this->portCode = $attributes['portCode'] ?? '';
        $this->portNameTH = $attributes['portNameTH'] ?? '';
        $this->portNameEN = $attributes['portNameEN'] ?? '';
        $this->countryCode = $attributes['countryCode'] ?? '';
        $this->isActive = $attributes['isActive'] ?? true;
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? Carbon::now();
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? Carbon::now();
    }

    // Add the missing abstract methods
    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $portCode = $value['portCode'];
        $portNameTH = $value['portNameTH'];
        $portNameEN = $value['portNameEN'];
        $countryCode = $value['countryCode'];
        $isActive = $value['isActive'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        return new static(['comCode' => $comCode, 'portCode' => $portCode, 'portNameTH' => $portNameTH, 'portNameEN' => $portNameEN, 'isActive' => $isActive, 'countryCode' => $countryCode, 'createID' => $createID, 'createTime' => $createTime, 'editID' => $editID, 'editTime' => $editTime]);

    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'portCode' => $this->portCode,
            'portNameTH' => $this->portNameTH,
            'portNameEN' => $this->portNameEN,
            'countryCode' => $this->countryCode,
            'isActive' => $this->isActive,
            'createID' => $this->createID,
            'createTime' =>  $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime
        ];
    }

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'countryCode','countryCode');
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
