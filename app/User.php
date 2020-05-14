<?php

namespace App;

use App\Http\Resources\Transaction;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username', 'birth_date', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'user_id', 'id');
    }

    public function promotionRequests()
    {
        return $this->hasMany('App\PromotionRequest', 'user_id', 'id');
    }

    public function cart()
    {
        return $this->hasOne('App\Cart', 'user_id', 'id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transcation', 'user_id', 'id');
    }
}
