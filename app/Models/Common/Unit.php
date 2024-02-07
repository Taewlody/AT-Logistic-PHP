<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'common_unit';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'unitCode';

    protected $dateFormat = 'y-m-d H:i:s';
    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $this->attributes['comCode'] ?? 'C01';
        $this->unitCode = $this->attributes['unitCode'] ?? '';
        $this->unitName = $this->attributes['unitName'] ?? '';
        $this->isActive = $this->attributes['isActive'] ?? '';
        $this->createID = $this->attributes['createID'] ?? '';
        $this->createTime = $this->attributes['createTime'] ?? '';
        $this->editID = $this->attributes['editID'] ?? '';
        $this->editTime = $this->attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value){
        return new static([
            'comCode' => $value['comCode'],
            'unitCode' => $value['unitCode'],
            'unitName' => $value['unitName'],
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
            'unitCode' => $this->unitCode,
            'unitName' => $this->unitName,
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
