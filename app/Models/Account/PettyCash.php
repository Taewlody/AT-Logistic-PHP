<?php

namespace App\Models\Account;

use App\Models\Common\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'documentDate' => 'date: Y-m-d',
        'dueDate' => 'date: Y-m-d',
        'refJobNo' => 'string',
        'supCode' => 'string',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'sumTotal' => 'float',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'sumTax1' => 'float',
        'sumTax3' => 'float',
        'sumTax7' => 'float',
        'grandTotal' => 'float',
    ];

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'supCode', 'supCode');
    }

    public function user(): HasOne{
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function docStatus(): HasOne
    {
        // ...

        return $this->hasOne(RefDocumentStatus::class, 'status_code', 'documentstatus');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'usercode', 'editID');
    }
}
