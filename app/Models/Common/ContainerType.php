<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class ContainerType extends Model
{
    use HasFactory;

    protected $table = 'common_containertype';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'containertypeCode';

    protected $fillable = [
        'comCode',
        'containertypeCode',
        'containertypeName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'containertypeCode' => 'string',
        'containertypeName' => 'string',
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
