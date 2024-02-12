<?php

namespace App\Models\PettyCash;

use App\Casts\CustomDate;
use App\Casts\CustomDateTime;
use App\Models\Common\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

use App\Models\Common\Customer;
use App\Models\Common\Saleman;
use App\Models\Common\TransportType;
use App\Models\Status\RefDocumentStatus;
use App\Models\User;

class PettyCash extends Model
{
    use HasFactory;

    protected $table = 'petty_cash';

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
        'dueDate',
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
        'sumTax1',
        'sumTax3',
        'sumTax7',
        'grandTotal',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => CustomDate::class,
        'dueDate' => CustomDate::class,
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
        'sumTax1' => 'float',
        'sumTax3' => 'float',
        'sumTax7' => 'float',
        'grandTotal' => 'float',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(PettyCashItems::class, 'documentID', 'documentID');
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'supCode', 'supCode');
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
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
