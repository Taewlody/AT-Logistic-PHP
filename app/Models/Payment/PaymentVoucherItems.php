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
    ];

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLivewire($value)
    {
        return new static($value);
    }

    public function toLivewire()
    {
        return $this->toArray();
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
