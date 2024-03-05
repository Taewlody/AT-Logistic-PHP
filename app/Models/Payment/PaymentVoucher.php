<?php

namespace App\Models\Payment;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\BankAccount;
use App\Models\PettyCash\PettyCash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Common\Supplier;
use App\Models\Status\RefDocumentStatus;
use App\Models\Marketing\JobOrder;
use Livewire\Wireable;

class PaymentVoucher extends Model implements Wireable
{
    use HasFactory;


    protected $table = 'payment_voucher';

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
        'sumTax1',
        'sumTax3',
        'sumTax7',
        'grandTotal',
        'purchasevat',
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
        'sumTax1' => 'float',
        'sumTax3' => 'float',
        'sumTax7' => 'float',
        'grandTotal' => 'float',
        'purchasevat' => 'boolean',
    ];

    protected array $rules = [
        'comCode'=> 'C01',
        'documentstatus'=> 'P',
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
        return $this->hasMany(PaymentVoucherItems::class, 'documentID', 'documentID');
    }

    public function pettyCash(): HasMany
    {
        return $this->hasMany(PettyCash::class, 'documentID', 'documentID');
    }


    public function Attach(): HasMany
    {
        return $this->hasMany(PaymentVoucherAttach::class, 'documentID', 'documentID');
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class, 'documentID', 'refJobNo');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class,'supCode', 'supCode');
    }

    public function docStatus(): HasOne
    {
        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'documentstatus');
    }

    public function account(): HasOne
    {
        return $this->hasOne(BankAccount::class, 'accountCode', 'accountCode');
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
