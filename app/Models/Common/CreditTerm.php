<?php

namespace App\Models\Common;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;
use Livewire\Wireable;

class CreditTerm extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'common_creditterm';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'creditCode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';
    
    protected $fillable = [
        'comCode',
        'creditCode',
        'creditName',
        'isActive',
        'createID',
        'createTime',
        'editID',
        'editTime',
    ];

    protected $casts = [
        'comCode' => 'string',
        'creditCode' => 'integer',
        'creditName' => 'string',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
    }

    public static function fromLiveWire($value): self
    {
        return new static($value);
    }

    public function toLiveWire(): array
    {
        return $this->toArray();
    }

}
