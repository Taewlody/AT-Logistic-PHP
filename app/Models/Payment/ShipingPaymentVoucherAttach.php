<?php

namespace App\Models\Payment;

use App\Models\Common\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class ShipingPaymentVoucherAttach extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'shiping_payment_voucher_attach';

    protected $primaryKey = 'items';

    public $timestamps = false;

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'supCode',
        'fileDetail',
        'fileName',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'supCode' => 'string',
        'fileDetail' => 'string',
        'fileName' => 'string',
    ];

    protected array $rules = [
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

    public function suppilers(): HasOne
    {
        return $this->hasOne(Supplier::class, 'supCode', 'supCode');
    }
}
