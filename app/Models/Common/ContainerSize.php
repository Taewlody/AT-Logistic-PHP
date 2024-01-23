<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class ContainerSize extends Model
{
    use HasFactory;

    protected $table = 'common_containersize';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'containersizeCode';

    protected $fillable = [
        'comCode',
        'containersizeCode',
        'containersizeName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'containersizeCode' => 'string',
        'containersizeName' => 'string',
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
