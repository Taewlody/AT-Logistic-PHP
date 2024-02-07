<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;

class TransportType extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_transporttype';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'transportCode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $fillable = [
        'comCode',
        'transportCode',
        'transportName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'transportCode' => 'string',
        'transportName' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $this->attributes['comCode'] ?? 'C01';
        $this->transportCode = $this->attributes['transportCode'] ?? '';
        $this->transportName = $this->attributes['transportName'] ?? '';
        $this->isActive = $this->attributes['isActive'] ?? '';
        $this->createID = $this->attributes['createID'] ?? '';
        $this->createTime = $this->attributes['createTime'] ?? '';
        $this->editID = $this->attributes['editID'] ?? '';
        $this->editTime = $this->attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'] ?? '';
        $transportCode = $value['transportCode'] ?? '';
        $transportName = $value['transportName'] ?? '';
        $isActive = $value['isActive'] ?? '';
        $createID = $value['createID'] ?? '';
        $createTime = $value['createTime'] ?? '';
        $editID = $value['editID'] ?? '';
        $editTime = $value['editTime'] ?? '';
        return new static([
            'comCode' => $comCode,
            'transportCode' => $transportCode,
            'transportName' => $transportName,
            'isActive' => $isActive,
            'createID' => $createID,
            'createTime' => $createTime,
            'editID' => $editID,
            'editTime' => $editTime,
        ]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'transportCode' => $this->transportCode,
            'transportName' => $this->transportName,
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
