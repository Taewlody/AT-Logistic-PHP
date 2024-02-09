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

    public function referContainerType(): HasOne
    {
        return $this->hasOne(ContainerType::class, 'containerType', 'containerType');
    }

    public function referContainerSize(): HasOne
    {
        return $this->hasOne(ContainerSize::class, 'containerSize', 'containerSize');
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
