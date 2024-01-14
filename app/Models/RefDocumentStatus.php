<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDocumentStatus extends Model
{
    use HasFactory;

    protected $table = 'ref_documentstatus';

    protected $fillable = [
        'comCode',
        'status_code',
        'status_name',
    ];

    protected $casts = [
        'comCode' => 'string',
        'status_code' => 'string',
        'status_name' => 'string'
    ];
}
