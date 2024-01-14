<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOrderGoods extends Model
{
    use HasFactory;

    protected $table = 'joborder_goods';

    protected $fillable = [
        'items',
        'comCode',
        'documentID',
        'goodNo',
        'goodDec',
        'goodWeight',
        'good_unit',
        'goodSize',
        'goodKind',
    ];

    protected $casts = [
        'items' => 'integer',
        'comCode' => 'string',
        'documentID' => 'string',
        'goodNo' => 'string',
        'goodDec' => 'string',
        'goodWeight' => 'float',
        'good_unit' => 'string',
        'goodSize' => 'string',
        'goodKind' => 'string',
    ];
}
