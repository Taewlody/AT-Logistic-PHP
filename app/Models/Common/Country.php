<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use Livewire\Wireable;

class Country extends Model
{
    use HasFactory;

    protected $table = 'common_country';

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
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M'
    ];

    public function toLivewire()
    {
        return [
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
    }

}
