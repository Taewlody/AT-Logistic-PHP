<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class Saleman extends Model
{
    use HasFactory;

    protected $table = 'common_saleman';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'empCode';

    protected $fillable = [
        'comCode',
        'empCode',
        'empName',
        'empSurname',
        'usercode',
        'mobile',
        'phone',
        'email',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'isActive'
    ];

    protected $casts = [
        'comCode' => 'string',
        'empCode' => 'string',
        'empName' => 'string',
        'empSurname' => 'string',
        'usercode' => 'string',
        'mobile' => 'string',
        'phone' => 'string',
        'email' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'isActive' => BooleanString::class
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
