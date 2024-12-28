<?php

namespace App\Models\Marketing;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\Commodity;
use App\Models\Common\Feeder;
use App\Models\Common\Place;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\PaymentVoucher;
use App\Models\PettyCash\PettyCash;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Common\TransportType;
use App\Models\Common\Port;
use App\Models\Common\Customer;
use App\Models\Status\RefDocumentStatus;
use App\Models\Account\Invoice;
use Livewire\Wireable;

class JobOrder extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'joborder';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    protected $connection = 'mysql';

    // public $timestamps = false;

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'bound',
        'freight',
        'port_of_landing',
        'port_of_discharge',
        'mbl',
        'hbl',
        'co',
        'paperless',
        'bill_of_landing',
        'import_entry',
        'etdDate',
        'etaDate',
        'closingDate',
        'closingTime',
        'invNo',
        'bill',
        'bookingNo',
        'deliveryType',
        'saleman',
        'cusCode',
        'cusContact',
        'agentCode',
        'agentContact',
        'feeder',
        'vessel',
        'internal_note',
        'note',
        'stu_location',
        'stu_contact',
        'stu_mobile',
        'stu_date',
        'cy_location',
        'cy_contact',
        'cy_mobile',
        'cy_date',
        'rtn_location',
        'rtn_contact',
        'rtn_mobile',
        'rtn_date',
        'good_total_num_package',
        'good_commodity',
        'billOfladingNo',
        'trailer_bookingNO',
        'invoiceNo',
        'fob',
        'place_receive',
        'total_amt',
        'total_vat',
        'tax3',
        'tax1',
        'cus_paid',
        'total_netamt',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'freetime',
        'freetimeEXP',
        'feederVOY',
        'vesselVOY',
        'commission_sale',
        'commission_customers',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'bound' => 'string',
        'freight' => 'string',
        'port_of_landing' => 'string',
        'port_of_discharge' => 'string',
        'mbl' => 'string',
        'hbl' => 'string',
        'co' => 'string',
        'paperless' => 'string',
        'bill_of_landing' => 'string',
        'import_entry' => 'string',
        'etdDate' => CustomDate::class,
        'etaDate' => CustomDate::class,
        'closingDate' => CustomDate::class,
        'closingTime' => 'string',
        'invNo' => 'string',
        'bill' => 'string',
        'bookingNo' => 'string',
        'deliveryType' => 'string',
        'saleman' => 'string',
        'cusCode' => 'string',
        'cusContact' => 'string',
        'agentCode' => 'string',
        'agentContact' => 'string',
        'feeder' => 'string',
        'vessel' => 'string',
        'note' => 'string',
        'internal_note' => 'string',
        'stu_location' => 'string',
        'stu_contact' => 'string',
        'stu_mobile' => 'string',
        'stu_date' => CustomDate::class,
        'cy_location' => 'string',
        'cy_contact' => 'string',
        'cy_mobile' => 'string',
        'cy_date' => CustomDate::class,
        'rtn_location' => 'string',
        'rtn_contact' => 'string',
        'rtn_mobile' => 'string',
        'rtn_date' => CustomDate::class,
        'good_total_num_package' => 'string',
        'good_commodity' => 'string',
        'billOfladingNo' => 'string',
        'trailer_bookingNO' => 'string',
        'invoiceNo' => 'string',
        'fob' => 'string',
        'place_receive' => 'string',
        'total_amt' => 'float',
        'total_vat' => 'float',
        'tax3' => 'float',
        'tax1' => 'float',
        'cus_paid' => 'float',
        'total_netamt' => 'float',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
        'freetime' => 'string',
        'freetimeEXP' => CustomDate::class,
        'feederVOY' => 'string',
        'vesselVOY' => 'string',
        'commission_sale' => 'float',
        'commission_customers' => 'float',
    ];

    protected $attributes = [
        // 'containerList' => [],
        'comCode' => 'C01',
        'documentstatus' => 'P',
        'commission_sale' => 0.00,
        'commission_customers' => 0.00,
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->documentID = self::genarateKey();
        });
    }

    public static function genarateKey(){
        $prefix = "REF".Carbon::now()->format('ym');
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

    public static function fromLivewire($value): JobOrder
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

    public function getBound(): Attribute {
        return Attribute::make(
            get: function() {
                if($this->bound == '1') 
                    return 'IN BOUND';
                else if($this->bound == '2') 
                return 'OUT BOUND';
                else return '';
            }
        );
    }
    public function attachs(): HasMany
    {
        return $this->hasMany(JobOrderAttach::class, 'documentID', 'documentID');
    }

    public function containerList(): HasMany
    {
        return $this->hasMany(JobOrderContainer::class, 'documentID', 'documentID');
    }

    public function qty(): Attribute {
        return Attribute::make(
            get: function() {
                if($this->containerList != null)
                    return $this->containerList->groupBy('size.containersizeName')->map(function ($item, $key) {
                        return collect($item)->count().'x'.$key;
                    })->toArray();
                return [];
            }
        );
    }

    public function sumPacked(): Attribute {
        return Attribute::make(
            get: function() {
                if($this->packedList != null)
                    $total = null;
                    foreach($this->packedList as $pack) {
                        $size = ($pack->packaed_width * $pack->packaed_length * $pack->packaed_height) / 1000000;
                        $sum = $size * $pack->packaed_qty;
                        $total += $sum;
                    }
                    
                    return round($total, 2);
                return [];
            }
        );
    }

    public function commodity(): BelongsToMany
    {
        return $this->belongsToMany(Commodity::class, 'ref_joborder__commodity', 'documentID', 'commodityCode');
    }

    public function addContainer(JobOrderContainer $container)
    {
        $this->containerList->push($container);
    }

    public function packedList(): HasMany
    {
        return $this->hasMany(JobOrderPacked::class, 'documentID', 'documentID');
    }

    public function addPacked(JobOrderPacked $packed)
    {
        $this->packedList->push($packed);
    }

    public function goodsList(): HasMany
    {
        return $this->hasMany(JobOrderGoods::class, 'documentID', 'documentID');
    }

    public function AdvancePayment(): HasMany
    {
        return $this->hasMany(AdvancePayment::class, 'refJobNo', 'documentID');
    }

    public function charge(): HasMany
    {
        return $this->hasMany(JobOrderCharge::class, 'documentID', 'documentID')
                    ->orderBy('chargeCode', 'ASC');
    }

    public function PaymentVoucher(): HasMany
    {
        return $this->hasMany(PaymentVoucher::class, 'refJobNo', 'documentID');
    }

    public function PettyCash(): HasMany
    {
        return $this->hasMany(PettyCash::class, 'refJobNo', 'documentID');
    }


    public function landingPort(): HasOne
    {
        return $this->hasOne(Port::class, 'portCode', 'port_of_landing');
    }

    public function trailerBooking(): HasOne
    {
        return $this->hasOne(TrailerBooking::class, 'ref_jobID', 'documentID');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'ref_jobNo', 'documentID');
    }

    public function billOfLanding(): HasOne
    {
        return $this->hasOne(BillOfLading::class, 'ref_jobID', 'documentID');
    }

    public function dischargePort(): HasOne
    {
        return $this->hasOne(Port::class, 'portCode', 'port_of_discharge');
    }

    public function transportType(): HasOne
    {
        return $this->hasOne(TransportType::class, 'transportCode', 'freight');
    }

    public function billLanding(): HasOne
    {
        return $this->hasOne(BillOfLading::class, 'documentID', 'bill_of_landing');
    }

    public function deliveryTypeRefer(): HasOne
    {
        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'deliveryType');
    }

    public function agentRefer(): HasOne
    {
        return $this->hasOne(Supplier::class, 'supCode', 'agentCode');
    }

    public function referFeeder(): HasOne
    {
        return $this->hasOne(Feeder::class, 'fCode', 'feeder');
    }
    public function vesselFeeder(): HasOne
    {
        return $this->hasOne(Feeder::class, 'fCode', 'vessel');
    }

    public function PlaceFOB(): HasOne
    {
        return $this->hasOne(Place::class, 'pCode', 'fob');
    }
    public function receivePlace(): HasOne
    {
        return $this->hasOne(Place::class, 'pCode', 'place_receive');
    }

    public function customerRefer(): HasOne
    {
        return $this->hasOne(Customer::class, 'cusCode', 'cusCode');
    }

    public function salemanRefer(): HasOne
    {
        return $this->hasOne(Saleman::class, 'usercode', 'saleman');
    }

    public function docStatus(): HasOne
    {
        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'documentstatus');
    }

    public function userCreate(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function userEdit(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
