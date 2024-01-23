<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class Feeder extends Model
{
    use HasFactory;

    protected $table = 'common_feeder';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'fCode';

    protected $fillable = [
        'comCode',
        'fCode',
        'fName',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'isActive'
    ];

    protected $casts = [
        'comCode' => 'string',
        'fCode' => 'string',
        'fName' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'isActive' => BooleanString::class
    ];

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
