<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use App\Models\Common\Country;

class Port extends Model
{
    use HasFactory;

    protected $table = 'common_port';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'portCode';

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
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M'
    ];

    public function country(): HasOne
    {
        return $this->hasOne(Country::class, 'countryCode','countryCode');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
