<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderContainer extends Model
{
    use HasFactory;

    protected $table = 'joborder_container';

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
}
