<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilVoting extends Model
{
    use HasFactory;
    protected $table = 'hasil_voting';
    protected $fillable = [
        'id_calon',
        'id_voting',
        'id_user_warga'
    ];
}
