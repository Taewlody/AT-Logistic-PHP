<?php

namespace App\Models\Payment;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\BankAccount;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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
        'dueTime' => 'string'
    ];

    protected $attributes = [
        'comCode' => 'C01',
        'documentstatus' => 'P'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->documentID = self::genarateKey();
        });
    }

    public static function genarateKey(){
        $prefix = "PV".Carbon::now()->format('ym');
        $lastKey = self::where('documentID', 'LIKE', $prefix.'%')->max('documentID');
        if($lastKey != null){
            $lastKey = intval(explode('-', $lastKey)[1]) + 1;
        }else{
            $lastKey = 1;
        }
        $index = str_pad($lastKey, 5, '0', STR_PAD_LEFT);
        return $prefix.'-'.$index;
    }

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
        return $this->hasMany(AdvancePaymentItems::class, 'documentID', 'documentID')?? new Collection;
    }

    public function attachs(): HasMany
    {
        return $this->hasMany(AdvancePaymentAttach::class, 'documentID', 'documentID') ?? new Collection;
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class, 'documentID', 'refJobNo');
    }

    public function accountBank(): HasOne
    {
        return $this->hasOne(BankAccount::class, 'accountCode', 'accountCode');
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
