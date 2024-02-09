<?php

namespace App\Models\Shipping;

use App\Models\Account\PaymentVoucherItems;
use App\Models\Account\PettyCash;
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
        'documentDate' => 'date: Y-m-d',
        'refJobNo' => 'string',
        'supCode' => 'string',
        'payType' => 'string',
        'payTypeOther' => 'string',
        'branch' => 'string',
        'chequeNo' => 'string',
        'dueDate' => 'date: Y-m-d',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'sumTotal' => 'float',
        'accountCode' => 'string',
        'sumTax1' => 'float',
        'sumTax3' => 'float',
        'sumTax7' => 'float',
        'grandTotal' => 'float',
        'purchasevat' => 'integer',
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLivewire($value)
    {
        return new static($value);
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    public function items(): HasMany
    {
        return $this->hasMany(PaymentVoucherItems::class, 'documentID', 'documentID');
    }

    public function pettyCash(): HasMany
    {
        return $this->hasMany(PettyCash::class, 'documentID', 'documentID');
    }

    public function pettyCashShipping(): HasMany
    {
        return $this->hasMany(PettyCashShipping::class, 'documentID', 'documentID');
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

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
