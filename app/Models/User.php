<?php

namespace App\Models;

use App\Casts\CustomDateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Casts\BooleanString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\Authenticatable;

use App\Models\UserType;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Livewire\Wireable;

class User extends Authenticatable implements Wireable {

    use HasApiTokens;
    // use Notifiable;

    protected $table = 'user';

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'usercode';

    protected $dateFormat = 'y-m-d H:i:s';

    const CREATED_AT = 'createTime';
    const UPDATED_AT = 'editTime';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comCode',
        'usercode',
        'userpass',
        'username',
        'surname',
        'userTypecode',
        'isActive',
        'createID',
        'createTime',
        'img_sinal',
        'editID',
        'editTime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'userpass',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'comCode' => 'string',
        'usercode' => 'string',
        'userpass' => 'string',
        'username' => 'string',
        'surname' => 'string',
        'userTypecode' => 'integer',
        'isActive' => BooleanString::class,
        'createID' => 'string',
        'createTime' => CustomDateTime::class,
        'img_sinal' => 'string',
        'editID' => 'string',
        'editTime' => CustomDateTime::class,
    ];

    protected $attributes = [
        'comCode' => 'C01',
        // 'userpass' => (string)env('APP_DEFUALT_PASSWORD', '123456'),
        // 'userpass' => '123456',
        'isActive' => false,
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

    public function UserType(): HasOne
    {
        return $this->hasOne(UserType::class, 'userTypecode', 'userTypecode');
    }

    public function createBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'createID');
    }

    public function editBy(): HasOne
    {
        return $this->hasOne(User::class, 'userCode', 'editID');
    }

    public function hasRole($role)
    {
        return strtolower($this->UserType->userTypeName) == strtolower($role);
    }

    public function getAuthIdentifier() {
        return $this->usercode;
    }

    public function getAuthPassword()
    {
        return $this->userpass;
    }

    public function validateCredentials(array $credentials)
    {
        $plain = $credentials['password'];
        return $this->hasher->check($plain, $this->getAuthPassword());
    }

}