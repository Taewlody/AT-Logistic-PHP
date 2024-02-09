<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;

class UnitContainer extends Model
{
    use HasFactory;

    protected $table = 'common_unit_containner';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'unitCode';

    protected $fillable = [
        'comCode',
        'unitCode',
        'unitName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'unitCode' => 'string',
        'unitName' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];
}
