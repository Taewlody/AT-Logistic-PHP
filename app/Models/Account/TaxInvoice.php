<?php

namespace App\Models\Account;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;


use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\TransportType;
use App\Models\Status\RefDocumentStatus;
use App\Models\User;
use Livewire\Wireable;

class TaxInvoice extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'tax_invoice';

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
        'cusCode',
        'cus_address',
        'saleman',
        'creditterm',
        'note',
        'remark',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'total_amt',
        'total_vat',
        'tax3',
        'tax1',
        'cus_paid',
        'total_netamt',
        'payType',
        'payTypeOther',
        'branch',
        'chequeNo',
        'dueDate',
        'dueTime',
        'accountCode',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'cusCode' => 'string',
        'cus_address' => 'string',
        'saleman' => 'string',
        'creditterm' => 'integer',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'total_amt' => 'float',
        'total_vat' => 'float',
        'tax3' => 'float',
        'tax1' => 'float',
        'cus_paid' => 'float',
        'total_netamt' => 'float',
        'payType' => 'string',
        'payTypeOther' => 'string',
        'branch' => 'string',
        'chequeNo' => 'string',
        'dueDate' => CustomDate::class,
        'dueTime' => 'string',
        'accountCode' => 'string',
        'taxivRef'=> 'string'
    ];

    protected $attributes = [
        'comCode' => 'C01',
        'documentstatus' => 'P',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->documentID = self::genarateKey();
        });
    }

    public static function genarateKey(){
        $prefix = "A".Carbon::now()->format('ym');
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
        return $this->hasMany(TaxInvoiceItems::class, 'documentID', 'documentID');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'cusCode', 'cusCode');
    }

    public function salemanRef(): HasOne
    {
        return $this->hasOne(Saleman::class, 'userCode', 'saleman');
    }

    public function transport(): HasOne{
        return $this->hasOne(TransportType::class, 'transportCode', 'freight');
    }

    public function user(): HasOne{
        return $this->hasOne(User::class, 'userCode', 'createID');
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
