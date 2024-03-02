<?php

namespace App\Models;

use App\Casts\CustomDateTime;
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