<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'remember_token'
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

    protected $rememberTokenName = 'remember_token';

    public function role()
    {
        return $this->belongsToMany(Role::class, 'user-role', 'user_id', 'role_id');
    }

    public function kasir()
    {
        return $this->hasOne(Kasir::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function generateActivationToken()
    {
        $this->remember_token = Str::random(60);
        $this->save();
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail($this));
    }
}
