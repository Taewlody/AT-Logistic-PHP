<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class Country extends Model
{
    use HasFactory;

    protected $table = 'common_country';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'countryCode';

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

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
    public function getTableColumns() {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
