<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Feeder;
use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\Supplier;
use App\Models\Marketing\JobOrder;
use App\Models\Status\RefDocumentStatus;
use App\Models\User;

class TrailerBooking extends Model
{
    use HasFactory;

    protected $table = 'trailer_booking';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'ref_jobID',
        'cusCode',
        'feeder',
        'agent',
        'tocompany',
        'companyContact',
        'work_order',
        'description',
        'loadplace',
        'packagingDate',
        'contact',
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
        'feeder' => 'string',
        'agent' => 'string',
        'tocompany' => 'string',
        'companyContact' => 'string',
        'work_order' => 'string',
        'description' => 'string',
        'loadplace' => 'string',
        'packagingDate' => 'string',
        'contact' => 'string',
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

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'supCode', 'agent');
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
