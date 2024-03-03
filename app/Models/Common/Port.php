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
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'editID');
    }
}
