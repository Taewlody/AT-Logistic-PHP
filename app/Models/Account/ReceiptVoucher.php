<?php

namespace App\Models\Account;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\BankAccount;
use App\Models\Marketing\JobOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\TransportType;
use App\Models\Status\RefDocumentStatus;
use App\Models\User;
use Livewire\Wireable;

class ReceiptVoucher extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'receipt_voucher';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

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
        'sumTax1',
        'sumTax3',
        'sumTax7',
        'grandTotal',
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
        'sumTax1' => 'float',
        'sumTax3' => 'float',
        'sumTax7' => 'float',
        'grandTotal' => 'float',
    ];

    protected $attributes = [
        'comCode'=> 'C01',
        'documentstatus'=> 'P',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->documentID = self::genarateKey();
        });
    }

    public static function genarateKey(){
        $prefix = "RV".Carbon::now()->format('ym');

        $documentIDs = self::where('documentID', 'LIKE', $prefix.'%')->pluck('documentID');
        
        $maxNumber = 0;

        foreach ($documentIDs as $documentID) {
           
            $numericPart = (int) substr($documentID, strlen($prefix) + 1); 
            
            if ($numericPart > $maxNumber) {
                $maxNumber = $numericPart;
            }
        }

        $newNumber = $maxNumber + 1;

        $index = str_pad($newNumber, 5, '0', STR_PAD_LEFT);
        
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
        return $this->hasMany(ReceiptVoucherItems::class, 'documentID', 'documentID');
    }

    public function attachs(): HasMany
    {
        return $this->hasMany(ReceiptVoucherAttach::class, 'documentID', 'documentID');
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class, 'documentID', 'refJobNo');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'cusCode', 'cusCode');
    }

    public function user(): HasOne{
        return $this->hasOne(User::class, 'userCode', 'createID');
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
