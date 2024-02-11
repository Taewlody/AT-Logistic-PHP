<?php

namespace App\Models\Payment;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Common\Customer;
use App\Models\Common\Feeder;
use App\Models\Status\RefDocumentStatus;
use App\Models\Marketing\JobOrder;
use Livewire\Wireable;

class AdvancePayment extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'advance_payment';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    // public $timestamps = false;

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'refJobNo',
        'cusCode',
        'payType',
        'payTypeOther',
        'branch',
        'chequeNo',
        'dueDate',
        'note',
        'remark',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'sumTotal',
        'accountCode',
        'dueTime'
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'refJobNo' => 'string',
        'cusCode' => 'string',
        'payType' => 'string',
        'payTypeOther' => 'string',
        'branch' => 'string',
        'chequeNo' => 'string',
        'dueDate' => 'date: Y-m-d',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'sumTotal' => 'float',
        'accountCode' => 'string',
        'dueTime' => 'string'
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLivewire($attributes = []): AdvancePayment
    {
        return new static($attributes);
    }

    public function toLiveWire()
    {
        return $this->toArray();
    }

    public function items(): HasMany
    {
        return $this->hasMany(AdvancePaymentItems::class, 'documentID', 'documentID');
    }

    public function Attach(): HasMany
    {
        return $this->hasMany(AdvancePaymentAttach::class, 'documentID', 'documentID');
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class, 'documentID', 'refJobNo');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class,'cusCode', 'cusCode');
    }

    public function docStatus(): HasOne
    {
        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'documentstatus');
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
