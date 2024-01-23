<?php

namespace App\Models\Marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\Common\ContainerType;
use App\Models\Common\ContainerSize;

class JobOrderContainer extends Model
{
    use HasFactory;

    protected $table = 'joborder_container';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

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

    public function containerType(): HasOne
    {
        return $this->hasOne(ContainerType::class, 'containerType', 'containerType');
    }

    public function containerSize(): HasOne
    {
        return $this->hasOne(ContainerSize::class, 'containerSize', 'containerSize');
    }
}
