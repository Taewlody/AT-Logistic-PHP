<?php

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Casts\BooleanString;

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

    public function isActive(){
        return $this->code == "1";
    }
}
