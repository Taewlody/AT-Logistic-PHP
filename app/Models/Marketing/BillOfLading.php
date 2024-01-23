<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Common\Customer;
use App\Models\Common\Feeder;
use App\Models\Status\RefDocumentStatus;

class BillOfLading extends Model
{
    use HasFactory;

    protected $table = 'bill_of_lading';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'ref_jobID',
        'cusCode',
        'shipperCode',
        'consigneeCode',
        'notify_party',
        'cargo_deliverry',
        'marks_number',
        'freight_detail',
        'prepaid',
        'collerct',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => 'date: Y-m-d',
        'ref_jobID' => 'string',
        'cusCode' => 'string',
        'shipperCode' => 'string',
        'consigneeCode' => 'string',
        'notify_party' => 'string',
        'cargo_deliverry' => 'string',
        'marks_number' => 'string',
        'freight_detail' => 'string',
        'prepaid' => 'string',
        'collerct' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'cusCode', 'cusCode');
    }

    public function feederRef(): HasOne
    {
        return $this->hasOne(Feeder::class, 'feederCode', 'feeder');
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class,'documentID','ref_jobID');
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
