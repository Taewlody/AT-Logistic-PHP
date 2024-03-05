<?php

namespace App\Models\PettyCash;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Common\Supplier;
use App\Models\Status\RefDocumentStatus;
use App\Models\Marketing\JobOrder;
use Livewire\Wireable;

class PettyCashShipping extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'petty_cashshiping';

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
        'supCode',
        'note',
        'remark',
        'documentstatus',
        'sumTotal',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'refJobNo' => 'string',
        'supCode' => 'string',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'sumTotal' => 'float',
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    protected $attributes = [
        'comCode'=> 'C01',
        'documentstatus'=> 'P',
    ];

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
        return $this->hasMany(PettyCashShippingItems::class, 'documentID', 'documentID');
    }

    public function jobOrder(): HasOne
    {
        return $this->hasOne(JobOrder::class, 'documentID', 'refJobNo');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class,'supCode', 'supCode');
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
