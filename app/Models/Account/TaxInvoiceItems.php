<?php

namespace App\Models\Account;

use App\Models\Common\Charges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class TaxInvoiceItems extends Model implements Wireable
{
    use HasFactory; 

    protected $table = 'tax_invoice_items';

    // public $incrementing = false;
    // protected $keyType = 'string';
    protected $primaryKey = 'items';

    public $timestamps = false;

    protected $fillable = [
        'items',
        'comCode',
        'invNo',
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
        'invNo' => 'string',
        'documentID' => 'string',
        'chargeCode' => 'string',
        'detail' => 'string',
        'chargesCost' => 'float',
        'chargesReceive' => 'float',
        'chargesbillReceive' => 'float',
    ];

    protected $attributes = [
        'comCode' => 'C001',
        'chargesCost' => 0,
        'chargesReceive' => 0,
        'chargesbillReceive' => 0,
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

    public function charges(): HasOne
    {
        return $this->hasOne(Charges::class, 'chargeCode', 'chargeCode');
    }

    public function taxInvoice(): BelongsTo
    {
        return $this->belongsTo(TaxInvoice::class, 'documentID', 'documentID');
    }
}
