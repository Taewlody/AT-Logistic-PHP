<?php

namespace App\Models;
use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class AttachFile extends Model implements Wireable
{

    protected $table = 'attach_file';
    protected $primaryKey = 'items';
    protected $dateFormat = 'y-m-d H:i:s';

    const UPDATED_AT = null;

    protected $fillable = [
        'items',
        'mimetype',
        'blobfile',
        'filename',
        'created_at'
    ];

    protected $casts = [
        'items' => 'integer',
        'mimetype'  => 'string',
        'blobfile' => 'string',
        'filename' => 'string', 
        'created_at'=> CustomDateTime::class,
    ];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->fill($attributes);
        $this->exists = $attributes['exists'] ?? false;
        $this->setConnection($attributes['connection'] ?? 'mysql');
    }

    public static function fromLivewire($value): self
    {
        return new static($value);
    }

    public function toLiveWire() : array
    {
        // return $this->toArray();
        $arr = $this->toArray();
        $arr['exists'] = $this->exists;
        $arr['connection'] = $this->getConnectionName();
        return $arr;
    }

    public function base64(): Attribute
    {
        return Attribute::make(get: function () {
            $base64 = base64_encode($this->blobfile ?? '');
            $mimetype = $this->mimeType ?? 'application/octet-stream';
            return "data:$mimetype;base64,$base64";
        });
    }
}