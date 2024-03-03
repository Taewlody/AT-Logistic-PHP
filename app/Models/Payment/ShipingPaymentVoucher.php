<?php

namespace App\Models\Payment;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\PettyCash\PettyCashShipping;
use App\Models\Status\RefDocumentStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class ShipingPaymentVoucher extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'shiping_payment_voucher';

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
        'supCode',
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
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'refJobNo' => 'string',
        'supCode' => 'string',
        'payType' => 'string',
        'payTypeOther' => 'string',
        'branch' => 'string',
        'chequeNo' => 'string',
        'dueDate' => CustomDate::class,
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'sumTotal' => 'float',
        'accountCode' => 'string',
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
        $this->exists = $attributes['exists'] ?? false;
        $this->setConnection($attributes['connection'] ?? 'mysql');
    }

    public static function fromLivewire($value): self
    {
        return new static($value);
    }

    public function toLiveWire() : array
    {
        // return $this->toArray();
        $arr = $this->toArray();
        $arr['exists'] = $this->exists;
        $arr['connection'] = $this->getConnectionName();
        return $arr;
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipingPaymentVoucherItems::class, 'documentID', 'documentID');
    }

    public function Attach(): HasMany
    {
        return $this->hasMany(ShipingPaymentVoucherAttach::class, 'documentID', 'documentID');
    }

    public function pettyCash(): HasMany
    {
        return $this->hasMany(PettyCashShipping::class, 'documentID', 'documentID');
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class, 'documentID', 'refJobNo');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'supCode', 'supCode');
    }

    public function docStatus(): HasOne
    {
        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'documentstatus');
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
