<?php

namespace App\Models\Marketing;

use App\Models\Common\Saleman;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Common\TransportType;
use App\Models\Common\Port;
use App\Models\Common\Customer;
use App\Models\Status\RefDocumentStatus;

class JobOrder extends Model
{
    use HasFactory;

    protected $table = 'joborder';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

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
        'documentDate' => 'date:Y-m-d',
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
        'etdDate' => 'date:Y-m-d',
        'etaDate' => 'date:Y-m-d',
        'closingDate' => 'date:Y-m-d',
        'closingTime' => 'time: H:M',
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
        'stu_date' => 'date:Y-m-d',
        'cy_location' => 'string',
        'cy_contact' => 'string',
        'cy_mobile' => 'string',
        'cy_date' => 'date:Y-m-d',
        'rtn_location' => 'string',
        'rtn_contact' => 'string',
        'rtn_mobile' => 'string',
        'rtn_date' => 'date:Y-m-d',
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
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'freetime' => 'string',
        'freetimeEXP' => 'date:Y-m-d',
        'feederVOY' => 'string',
        'vesselVOY' => 'string',
    ];

    public function portLanding(): HasOne
    {
        return $this->hasOne(Port::class, 'portCode', 'port_of_landing');
    }


    public function portDischarge(): HasOne
    {
        return $this->hasOne(Port::class, 'portCode', 'port_of_discharge');
    }

    public function freightRef(): HasOne
    {
        return $this->hasOne(TransportType::class, 'transportCode', 'freight');
    }

    // public function bill_of_landing(): HasOne {

    // }

    public function docStatus(): HasOne
    {
        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'documentstatus');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'cusCode', 'cusCode');
    }

    public function salemanRef(): HasOne
    {
        return $this->hasOne(Saleman::class, 'usercode', 'saleman');
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
