<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Casts\BooleanString;

class User extends Authenticatable {

    use HasApiTokens;

    protected $table = 'user';

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

}