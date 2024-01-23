<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'user_type';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'userTypecode';

    protected $fillable = [
        'comCode',
        'userTypecode',
        'userTypeName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime'
    ];

    protected $casts = [
        'comCode' => 'string',
        'userTypecode' => 'integer',
        'userTypeName' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'editID');
    }
}
