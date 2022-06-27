<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusSurat extends Model
{
    use HasFactory;
    protected $table = 'status_surat';

    protected $fillable = [
        'status',
    ];
}
