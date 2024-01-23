<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class Place extends Model
{
    use HasFactory;

    protected $table = 'common_place';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'pCode';

    protected $fillable = [
        'comCode',
        'pCode',
        'pName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'pCode' => 'string',
        'pName' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
