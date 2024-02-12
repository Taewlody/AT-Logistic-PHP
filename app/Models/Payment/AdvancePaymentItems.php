<?php

namespace App\Models\Payment;

use App\Models\Common\Charges; // Add the missing import statement
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class AdvancePaymentItems extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'advance_payment_items';

    protected $primaryKey = 'items';

    public $timestamps = false;

    protected $fillable = [
        'autoid',
        'comCode',
        'documentID',
        'invNo',
        'chargeCode',
        'chartDetail',
        'amount'
    ];

    protected $casts = [
        'items' => 'integer',
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

    public static function fromLivewire($value)
    {
        return new static($value);
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    

    public function charge(): HasOne
    {
        return $this->hasOne(Charges::class, 'chargeCode', 'chargeCode');
    }
}
