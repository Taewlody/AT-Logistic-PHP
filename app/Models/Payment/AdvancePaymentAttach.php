<?php

namespace App\Models\Payment;

use App\Models\AttachFile;
use App\Models\Common\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class AdvancePaymentAttach extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'advance_payment_attach';

    protected $primaryKey = 'items';

    public $timestamps = false;

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'cusCode',
        'fileDetail',
        'fileName',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'cusCode' => 'string',
        'fileDetail' => 'string',
        'fileName' => 'string',
    ];

    protected $attributes = [
        'comCode'=> 'C01',
    ];

    public static function boot()
    {
        parent::boot();
        self::deleting(function($model){
            if($model->blobFile){
                $model->blobFile->delete();
            }
        });
    }
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

    public function advancePayment(): BelongsTo
    {
        return $this->belongsTo(AdvancePayment::class, 'documentID', 'documentID');
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'cusCode', 'cusCode');
    }

    public function blobFile(): HasOne
    {
        return $this->hasOne(AttachFile::class, 'filename', 'fileName');
    }
}
