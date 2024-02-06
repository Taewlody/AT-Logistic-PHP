<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use App\Models\User;
use Livewire\Wireable;
use Carbon\Carbon;

class Feeder extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_feeder';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'fCode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'isActive' => BooleanString::class
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? '';
        $this->fCode = $attributes['fCode'] ?? '';
        $this->fName = $attributes['fName'] ?? '';
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
        $this->isActive = $attributes['isActive'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $fCode = $value['fCode'];
        $fName = $value['fName'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        $isActive = $value['isActive'];
        return new static([
            'comCode' => $comCode,
            'fCode' => $fCode,
            'fName' => $fName,
            'createID' => $createID,
            'createTime' => $createTime,
            'editID' => $editID,
            'editTime' => $editTime,
            'isActive' => $isActive
        ]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'fCode' => $this->fCode,
            'fName' => $this->fName,
            'createID' => $this->createID,
            'createTime' => $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime,
            'isActive' => $this->isActive
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
