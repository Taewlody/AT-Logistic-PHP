<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefActive extends Model
{
    use HasFactory;

    protected $table = 'ref_active';

    protected $fillable = [
        'comCode',
        'code',
        'activeName',
    ];

    protected $casts = [
        'comCode' => 'string',
        'code' => 'string',
        'activeName' => 'string'
    ];
}
