<?php

namespace App\Models\Common;

use App\Models\AttachFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Livewire\Wireable;

class Company extends Model implements Wireable
{
    use HasFactory;

    protected $table = 'company';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'com_code';

    public $timestamps = false;

    protected $fillable = [
        'com_code',
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
        'com_code' => 'string',
        'comname' => 'string',
        'taxID' => 'string',
        'address' => 'string',
        'address_en' => 'string',
        'telephone' => 'string',
        'fax' => 'string',
        'logo' => 'string',
        'comnameEN' => 'string',
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

    public function logoBase64(): Attribute
    {
        return Attribute::make(get: function () {
            $file = AttachFile::where('filename', $this->logo)->first();
            if(!$file) return '';
            $base64 = base64_encode($file->blobfile ?? '');
            $mimetype = $file->mimetype ?? 'application/octet-stream';
            return "data:$mimetype;base64,$base64";
        });
    }

   
}
