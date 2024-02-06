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

class Saleman extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_saleman';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'empCode';

    // public $timestamps = false;

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'isActive' => BooleanString::class
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? 'C01';
        $this->empCode = $attributes['empCode'] ?? '';
        $this->empName = $attributes['empName'] ?? '';
        $this->empSurname = $attributes['empSurname'] ?? '';
        $this->usercode = $attributes['usercode'] ?? '';
        $this->mobile = $attributes['mobile'] ?? '';
        $this->phone = $attributes['phone'] ?? '';
        $this->email = $attributes['email'] ?? '';
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
        $this->isActive = $attributes['isActive'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $empCode = $value['empCode'];
        $empName = $value['empName'];
        $empSurname = $value['empSurname'];
        $usercode = $value['usercode'];
        $mobile = $value['mobile'];
        $phone = $value['phone'];
        $email = $value['email'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        $isActive = $value['isActive'];
        return new static(['comCode' => $comCode, 'empCode' => $empCode, 'empName' => $empName, 'empSurname' => $empSurname, 'usercode' => $usercode, 'mobile' => $mobile, 'phone' => $phone, 'email' => $email, 'createID' => $createID, 'createTime' => $createTime, 'editID' => $editID, 'editTime' => $editTime, 'isActive' => $isActive]);
    }

    public function toLivewire()
    {
        return [
            'comCode' => $this->comCode,
            'empCode' => $this->empCode,
            'empName' => $this->empName,
            'empSurname' => $this->empSurname,
            'usercode' => $this->usercode,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'email' => $this->email,
            'createID' => $this->createID,
            'createTime' => $this->createTime,
            'editID' => $this->editID,
            'editTime' => $this->editTime,
            'isActive' => $this->isActive
        ];
    }
    public function userRefer(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'usercode');
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
