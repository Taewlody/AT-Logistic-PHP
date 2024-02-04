<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;

class ContractPerson extends Model
{
    use HasFactory;

    protected $table = 'common_contractperson';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'contactCode';
    protected $fillable = [
        'comCode',
        'contactCode',
        'cusCode',
        'contactNameEN',
        'contactNameTH',
        'taxID',
        'th_addressNo',
        'th_moo',
        'th_village',
        'th_soi',
        'th_road',
        'th_subdistrict',
        'th_district',
        'th_province',
        'zipCode',
        'th_addressbill',
        'en_addressNo',
        'en_moo',
        'en_addressbill',
        'en_village',
        'en_soi',
        'en_road',
        'en_subdistrict',
        'en_district',
        'en_province',
        'countryCode',
        'tel',
        'fax',
        'mobile',
        'mail',
        'lineID',
        'website',
        'note',
        'IsActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'contactCode' => 'string',
        'cusCode' => 'string',
        'contactNameEN' => 'string',
        'contactNameTH' => 'string',
        'taxID' => 'string',
        'th_addressNo' => 'string',
        'th_moo' => 'string',
        'th_village' => 'string',
        'th_soi' => 'string',
        'th_road' => 'string',
        'th_subdistrict' => 'string',
        'th_district' => 'string',
        'th_province' => 'string',
        'zipCode' => 'string',
        'th_addressbill' => 'string',
        'en_addressNo' => 'string',
        'en_moo' => 'string',
        'en_addressbill' => 'string',
        'en_village' => 'string',
        'en_soi' => 'string',
        'en_road' => 'string',
        'en_subdistrict' => 'string',
        'en_district' => 'string',
        'en_province' => 'string',
        'countryCode' => 'string',
        'tel' => 'string',
        'fax' => 'string',
        'mobile' => 'string',
        'mail' => 'string',
        'lineID' => 'string',
        'website' => 'string',
        'note' => 'string',
        'IsActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => 'datetime:Y-m-d H:i',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:i',
    ];
}
