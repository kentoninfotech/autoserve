<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'setting_id',
        'password',
        'role',
        'status',
        'state',
        'facility',
    ];

    public function hasRole($role)
    {
        return $this->role === $role;
    }


    public function setting()
    {
        return $this->hasOne(settings::class);
    }

    public function settings()
    {
        return $this->belongsTo(settings::class, 'setting_id');
    }

    public function personnel()
    {
        return $this->hasOne(personnel::class, 'user_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
}
