<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserWarga extends Model implements AuthenticatableContract
{
    use HasFactory, Notifiable;
    use Authenticatable;
    protected $guard = 'user_warga';
    protected $table = 'user_warga';
    protected $fillable = [
        'nik',
        'email',
        'password'
    ];
}
