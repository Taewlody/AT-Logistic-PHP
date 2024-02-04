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
use Illuminate\Support\Facades\Log;


class Country extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_country';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'countryCode';
    public $timestamps = false;

    protected $fillable = [
        'comCode',
        'countryCode',
        'countryNameTH',
        'countryNameEN',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime'
    ];

    protected $casts = [
        'comCode' => 'string',
        'countryCode' => 'string',
        'countryNameTH' => 'string',
        'countryNameEN' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class
    ];

    // protected $dates = [
    //     'createTime',
    //     'editTime'
    // ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? 'C01';
        $this->countryCode = $attributes['countryCode'] ?? '';
        $this->countryNameTH = $attributes['countryNameTH'] ?? '';
        $this->countryNameEN = $attributes['countryNameEN'] ?? '';
        $this->isActive = $attributes['isActive'] ?? false;
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
    }

    // Add the missing abstract methods
    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $countryCode = $value['countryCode'];
        $countryNameTH = $value['countryNameTH'];
        $countryNameEN = $value['countryNameEN'];
        $isActive = $value['isActive'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        return new static(['comCode' => $comCode, 'countryCode' => $countryCode, 'countryNameTH' => $countryNameTH, 'countryNameEN' => $countryNameEN, 'isActive' => $isActive, 'createID' => $createID, 'createTime' => $createTime, 'editID' => $editID, 'editTime' => $editTime]);

    }

    public function toLivewire()
    {
        Log::debug("date: ".$this->createTime);
        return [
            'comCode' => $this->comCode,
            'countryCode' => $this->countryCode,
            'countryNameTH' => $this->countryNameTH,
            'countryNameEN' => $this->countryNameEN,
            'isActive' => $this->isActive,
            'createID' => $this->createID,
            'createTime' =>  $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime
        ];
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
