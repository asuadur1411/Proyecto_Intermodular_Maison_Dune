<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'email',
        'name',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
