<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrailerBooking extends Model
{
    use HasFactory;

    protected $table = 'trailer_booking';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'ref_jobID',
        'cusCode',
        'feeder',
        'agent',
        'tocompany',
        'companyContact',
        'work_order',
        'description',
        'loadplace',
        'packagingDate',
        'contact',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => 'date: Y-m-d',
        'ref_jobID' => 'string',
        'cusCode' => 'string',

        'feeder' => 'string',
        'agent' => 'string',
        'tocompany' => 'string',
        'companyContact' => 'string',
        'work_order' => 'string',
        'description' => 'string',
        'loadplace' => 'string',
        'packagingDate' => 'string',
        'contact' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];
}
