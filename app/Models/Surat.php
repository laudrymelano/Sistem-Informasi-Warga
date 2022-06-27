<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $table = 'surat';
    protected $fillable = [
        'id',
        'id_user_warga',
        'id_status_surat',
        'no_surat',
        'keperluan',
        'keterangan',
        'catatan',
        'created_at',
        'lainnya',
        'update_at'
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d M Y');
    }
}
