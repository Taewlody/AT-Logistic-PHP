<?php

namespace App\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Charges;
use Livewire\Wireable;

class InvoiceItems extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'invoice_items';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'chargeCode',
        'detail',
        'chargesCost',
        'chargesReceive',
        'chargesbillReceive',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'chargeCode' => 'string',
        'detail' => 'string',
        'chargesCost' => 'float',
        'chargesReceive' => 'float',
        'chargesbillReceive' => 'float',
    ];

    public function charges(): HasOne
    {
        return $this->hasOne(Charges::class, 'chargeCode', 'chargeCode');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLiveWire($value): self
    {
        return new static($value);
    }

    public function toLiveWire(): array
    {
        return $this->toArray();
    }
}
