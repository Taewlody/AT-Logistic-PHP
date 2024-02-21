<?php

namespace App\Models\Account;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\TransportType;
use App\Models\Status\RefDocumentStatus;
use App\Models\User;
use App\Models\Account\TaxInvoiceItems;
use Livewire\Wireable;

class Invoice extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'invoice';

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
        'carrier',
        'saleman',
        'creditterm',
        'your_RefNo',
        'bound',
        'commodity',
        'on_board',
        'freight',
        'qty_measurement',
        'bl_No',
        'ref_jobNo',
        'origin_desc',
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
        'taxivRef',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'cusCode' => 'string',
        'cus_address' => 'string',
        'carrier' => 'string',
        'saleman' => 'string',
        'creditterm' => 'integer',
        'your_RefNo' => 'string',
        'bound' => 'string',
        'commodity' => 'string',
        'on_board' => 'string',
        'freight' => 'string',
        'qty_measurement' => 'string',
        'bl_No' => 'string',
        'ref_jobNo' => 'string',
        'origin_desc' => 'string',
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
        'taxivRef' => 'string',
    ];

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLiveWire($value): self
    {
        return new static($value);
    }

    public function toLiveWire(): array
    {
        return $this->toArray();
    }

    public function items() : HasMany
    {
        return $this->hasMany(InvoiceItems::class, 'documentID', 'documentID');
    }

    public function taxInvoiceItems() : HasMany
    {
        return $this->hasMany(TaxInvoiceItems::class, 'comCode', 'comCode')
        ->whereColumn('invoice.documentID', 'tax_invoice_items.invNo');
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
