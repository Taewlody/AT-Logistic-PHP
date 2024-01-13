<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';

    protected $fillable = [
        'comCode',
        'documentID',
        'documentDate',
        'cusCode',
        'cus_address',
        'carrier',
        'saleman',
        'creditterm',
        'your_RefNo',
        'bound',
        'commodity',
        'on_board',
        'freight',
        'qty_measurement',
        'bl_No',
        'ref_jobNo',
        'origin_desc',
        'note',
        'remark',
        'documentstatus',
        'createID',
        'createTime',
        'editID',
        'editTime',
        'total_amt',
        'total_vat',
        'tax3',
        'tax1',
        'cus_paid',
        'total_netamt',
        'taxivRef',
    ];

    protected $casts = [
        'comCode' => 'string',
        'documentID' => 'string',
        'documentDate' => 'date: Y-m-d',
        'cusCode' => 'string',
        'cus_address' => 'string',
        'carrier' => 'string',
        'saleman' => 'string',
        'creditterm' => 'integer',
        'your_RefNo' => 'string',
        'bound' => 'string',
        'commodity' => 'string',
        'on_board' => 'string',
        'freight' => 'string',
        'qty_measurement' => 'string',
        'bl_No' => 'string',
        'ref_jobNo' => 'string',
        'origin_desc' => 'string',
        'note' => 'string',
        'remark' => 'string',
        'documentstatus' => 'string',
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:M',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
        'total_amt' => 'float',
        'total_vat' => 'float',
        'tax3' => 'float',
        'tax1' => 'float',
        'cus_paid' => 'float',
        'total_netamt' => 'float',
        'taxivRef' => 'string',
    ];
}
