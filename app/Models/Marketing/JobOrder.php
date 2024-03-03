<?php

namespace App\Models\Marketing;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\Feeder;
use App\Models\Common\Place;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Payment\AdvancePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Common\TransportType;
use App\Models\Common\Port;
use App\Models\Common\Customer;
use App\Models\Status\RefDocumentStatus;
use App\Models\Account\Invoice;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Livewire\Wireable;

class JobOrder extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'joborder';

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
    ];

    protected $attributes = [
        // 'containerList' => [],
    ];

    public function id(){
        return $this->documentID;
    }

    public static function GenKey(){
        return self::getDocumentID();
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

    public function containerList(): HasMany
    {
        return $this->hasMany(JobOrderContainer::class, 'documentID', 'documentID');
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
        return $this->hasMany(JobOrderCharge::class, 'documentID', 'documentID');
    }

    public function landingPort(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'portCode', 'port_of_landing');
    }

    public function trailerBooking(): BelongsTo
    {
        return $this->belongsTo(TrailerBooking::class, 'documentID', 'trailer_bookingNO');
    }

    public function dischargePort(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'portCode', 'port_of_discharge');
    }

    public function transportType(): BelongsTo
    {
        return $this->belongsTo(TransportType::class, 'transportCode', 'freight');
    }

    public function billLanding(): BelongsTo
    {
        return $this->belongsTo(BillOfLading::class, 'documentID', 'bill_of_landing');
    }

    public function deliveryTypeRefer(): BelongsTo
    {
        return $this->belongsTo(RefDocumentStatus::class, 'status_code', 'deliveryType');
    }

    public function agentRefer(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supCode', 'agentCode');
    }

    public function referFeeder(): BelongsTo
    {
        return $this->belongsTo(Feeder::class, 'feederCode', 'feeder');
    }
    public function vesselFeeder(): BelongsTo
    {
        return $this->belongsTo(Feeder::class, 'feederCode', 'feeder');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'documentID', 'invoiceNo');
    }

    public function referInvoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'ref_jobNo', 'documentID');
    }

    public function PlaceFOB(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'pCode', 'fob');
    }
    public function receivePlace(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'pCode', 'place_receive');
    }

    public function customerRefer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'cusCode', 'cusCode');
    }

    public function salemanRefer(): BelongsTo
    {
        return $this->belongsTo(Saleman::class, 'usercode', 'saleman');
    }

    public function docStatus(): BelongsTo
    {
        return $this->belongsTo(RefDocumentStatus::class, 'status_code', 'documentstatus');
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
