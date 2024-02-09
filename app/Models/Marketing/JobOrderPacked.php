<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\Unit;
use Livewire\Wireable;

class JobOrderPacked extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'joborder_packed';
    
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'packaed_width',
        'packaed_length',
        'packaed_height',
        'packaed_qty',
        'packaed_weight',
        'packaed_unit',
        'packaed_totalCBM',
        'packaed_totalWeight',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'packaed_width' => 'float',
        'packaed_length' => 'float',
        'packaed_height' => 'float',
        'packaed_qty' => 'float',
        'packaed_weight' => 'float',
        'packaed_unit' => 'string',
        'packaed_totalCBM' => 'float',
        'packaed_totalWeight' => 'float',
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

    public function unit() : HasOne
    {
        return $this->hasOne(Unit::class, 'unitCode', 'packaed_unit');
    }
}
