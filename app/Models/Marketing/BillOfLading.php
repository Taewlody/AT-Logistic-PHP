<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillOfLading extends Model
{
    use HasFactory;

    protected $table = 'bill_of_lading';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'ref_jobID',
        'cusCode',
        'shipperCode',
        'consigneeCode',
        'notify_party',
        'cargo_deliverry',
        'marks_number',
        'freight_detail',
        'prepaid',
        'collerct',
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
        'shipperCode' => 'string',
        'consigneeCode' => 'string',
        'notify_party' => 'string',
        'cargo_deliverry' => 'string',
        'marks_number' => 'string',
        'freight_detail' => 'string',
        'prepaid' => 'string',
        'collerct' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];
}
