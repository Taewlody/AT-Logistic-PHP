<?php

namespace App\Models\Marketing;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
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
use Livewire\Wireable;

class TrailerBooking extends Model implements Wireable
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
        'documentDate' => CustomDate::class,
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
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLivewire($value): TrailerBooking
    {
        return new static($value);
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }

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

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }

}
