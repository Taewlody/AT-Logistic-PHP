<?php

namespace App\Models\Marketing;

use App\Models\Common\UnitContainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\ContainerType;
use App\Models\Common\ContainerSize;
use Livewire\Wireable;

class JobOrderContainer extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'joborder_container';
    // public $incrementing = false;
    // protected $keyType = 'string';
    protected $primaryKey = 'items';

    public $timestamps = false;

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'containerType',
        'containerSize',
        'containerNo',
        'containerSealNo',
        'containerGW',
        'containerGW_unit',
        'containerNW',
        'containerNW_Unit',
        'containerTareweight',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'containerType' => 'string',
        'containerSize' => 'string',
        'containerNo' => 'string',
        'containerSealNo' => 'string',
        'containerGW' => 'string',
        'containerGW_unit' => 'string',
        'containerNW' => 'string',
        'containerNW_Unit' => 'string',
        'containerTareweight' => 'string',
    ];

    protected $attributes = [
        'comCode' => 'C01',
        'containerType' => '',
        'containerSize' => '',
        'containerNo' => '',
        'containerSealNo' => '',
        'containerGW' => '0',
        'containerGW_unit' => '',
        'containerNW' => '0',
        'containerNW_Unit' => '',
        'containerTareweight' => '',
    ];

    public function id(){
        return $this->items;
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

    public function type(): HasOne
    {
        return $this->hasOne(ContainerType::class, 'containerType', 'containerType')->with;
    }

    public function size(): HasOne
    {
        return $this->hasOne(ContainerSize::class, 'containersizeCode', 'containerSize');
    }

    public function referGW_Unit(): HasOne
    {
        return $this->hasOne(UnitContainer::class, 'unitCode', 'containerGW_unit');
    }

    public function referNW_Unit(): HasOne
    {
        return $this->hasOne(UnitContainer::class, 'unitCode', 'containerNW_Unit');
    }
}
