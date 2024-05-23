<?php

namespace App\Models\Payment;

use App\Models\Account\Invoice;
use App\Models\Common\Charges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class PaymentVoucherItems extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'payment_voucher_items';

    // public $incrementing = false;
    // protected $keyType = 'string';
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
        'tax',
        'taxamount',
        'vat',
        'vatamount',
        'GrandTotal',
    ];

    protected $casts = [
        'autoid' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'invNo' => 'string',
        'chargeCode' => 'string',
        'chartDetail' => 'string',
        'amount' => 'float',
        'tax' => 'integer',
        'taxamount' => 'float',
        'vat' => 'integer',
        'vatamount' => 'float',
        'GrandTotal' => 'float',
    ];

    protected $attributes = [
        'comCode'=> 'C01',
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

    public function invoce(): HasOne
    {
        return $this->hasOne(Invoice::class, 'documentID', 'invNo');
    }

    public function charges(): HasOne
    {
        return $this->hasOne(Charges::class, 'chargeCode', 'chargeCode');
    }
}
