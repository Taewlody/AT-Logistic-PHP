<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;

class Place extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_place';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'pCode';
    protected $dateFormat = 'y-m-d H:i:s';
    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $this->attributes['comCode'] ?? 'C01';
        $this->pCode = $this->attributes['pCode'] ?? '';
        $this->pName = $this->attributes['pName'] ?? '';
        $this->isActive = $this->attributes['isActive'] ?? '';
        $this->createID = $this->attributes['createID'] ?? '';
        $this->createTime = $this->attributes['createTime'] ?? '';
        $this->editID = $this->attributes['editID'] ?? '';
        $this->editTime = $this->attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value){
        return new static([
            'comCode' => $value['comCode'],
            'pCode' => $value['pCode'],
            'pName' => $value['pName'],
            'isActive' => $value['isActive'],
            'createID' => $value['createID'],
            'createTime' => $value['createTime'],
            'editID' => $value['editID'],
            'editTime' => $value['editTime'],
        ]);
    }

    public function toLivewire(){
        return [
            'comCode' => $this->comCode,
            'pCode' => $this->pCode,
            'pName' => $this->pName,
            'isActive' => $this->isActive,
            'createID' => $this->createID,
            'createTime' => $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime,
        ];
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode','editID');
    }
}
