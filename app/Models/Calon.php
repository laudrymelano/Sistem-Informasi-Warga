<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calon extends Model
{
    use HasFactory;
    protected $table = 'calon';
    protected $fillable = [
        'id_voting',
        'no_urut',
        'nama',
        'visi',
        'thumbnail',
        'periode'
    ];
}
