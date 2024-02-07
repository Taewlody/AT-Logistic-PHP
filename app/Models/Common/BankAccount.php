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

class BankAccount extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_account';
    
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'accountCode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $fillable = [
        'comCode',
        'accountCode',
        'accountName',
        'accountNicname',
        'accountID',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'accountCode' => 'string',
        'accountName' => 'string',
        'accountNicname' => 'string',
        'accountID' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->accountCode .= 'C-' . str_pad(BankAccount::count() + 1, 8, '0', STR_PAD_LEFT);
    //         $model->createTime = Carbon::now();
    //         $model->editTime = Carbon::now();
    //     });
    //     static::updating(function ($model) {
    //         $model->editTime = Carbon::now();
    //     });
    // }

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->comCode = $attributes['comCode'] ?? 'C01';
        $this->accountCode = $attributes['accountCode'] ?? '';
        $this->accountName = $attributes['accountName'] ?? '';
        $this->accountNicname = $attributes['accountNicname'] ?? '';
        $this->accountID = $attributes['accountID'] ?? '';
        $this->isActive = $attributes['isActive'] ?? '';
        $this->createID = $attributes['createID'] ?? '';
        $this->createTime = $attributes['createTime'] ?? '';
        $this->editID = $attributes['editID'] ?? '';
        $this->editTime = $attributes['editTime'] ?? '';
    }

    public static function fromLivewire($value)
    {
        $comCode = $value['comCode'];
        $accountCode = $value['accountCode'];
        $accountName = $value['accountName'];
        $accountNicname = $value['accountNicname'];
        $accountID = $value['accountID'];
        $isActive = $value['isActive'];
        $createID = $value['createID'];
        $createTime = $value['createTime'] != '' ? Carbon::parse($value['createTime']) : Carbon::minValue();
        $editID = $value['editID'];
        $editTime = $value['editTime'] != '' ? Carbon::parse($value['editTime']) : Carbon::minValue();
        return new static([
            'comCode' => $comCode,
            'accountCode' => $accountCode,
            'accountName' => $accountName,
            'accountNicname' => $accountNicname,
            'accountID' => $accountID,
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
            'accountCode' => $this->accountCode,
            'accountName' => $this->accountName,
            'accountNicname' => $this->accountNicname,
            'accountID' => $this->accountID,
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
