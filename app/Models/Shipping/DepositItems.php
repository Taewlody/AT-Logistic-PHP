<?php

namespace App\Models\Shipping;

use App\Models\Account\Invoice;
use App\Models\Common\Charges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class DepositItems extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'deposit_items';

    protected $primaryKey = 'autoid';

    public $timestamps = false;

    protected $fillable = [
        'autoid',
        'comCode',
        'documentID',
        'invNo',
        'chargeCode',
        'chartDetail',
        'amount',
    ];

    protected $casts = [
        'autoid' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'invNo' => 'string',
        'chargeCode' => 'string',
        'chartDetail' => 'string',
        'amount' => 'float',
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLiveWire($value): self
    {
        return new static($value);
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'documentID', 'invNo');
    }

    public function charge(): HasOne
    {
        return $this->hasOne(Charges::class, 'chargeCode', 'chargeCode');
    }
}
