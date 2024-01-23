<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    protected $fillable = [
        'comCode',
        'comname',
        'taxID',
        'address',
        'address_en',
        'telephone',
        'fax',
        'logo',
        'comnameEN',
    ];

    protected $casts = [
        'comCode' => 'string',
        'comname' => 'string',
        'taxID' => 'string',
        'address' => 'string',
        'address_en' => 'string',
        'telephone' => 'string',
        'fax' => 'string',
        'logo' => 'string',
        'comnameEN' => 'string',
    ];
}
