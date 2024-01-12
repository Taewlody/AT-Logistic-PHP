<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Casts\BooleanString;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Contracts\Auth\Authenticatable;

class User extends Authenticatable {

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
        'createTime' => 'datetime:Y-m-d H:M',
        'img_sinal' => 'string',
        'editID' => 'string',
        'editTime' => 'datetime:Y-m-d H:M',
    ];

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