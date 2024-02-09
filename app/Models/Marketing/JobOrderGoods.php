<?php

namespace App\Models\Marketing;

use App\Models\Common\UnitContainer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class JobOrderGoods extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'joborder_goods';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'documentID';

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

    public function __construct($attributes = []){
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLivewire($value)
    {
        return new static($value);
    }

    public function toLivewire()
    {
        return $this->toArray();
    }

    public function unit(): HasOne
    {
        return $this->hasOne(UnitContainer::class, 'unitCode', 'good_unit');
    }
}
