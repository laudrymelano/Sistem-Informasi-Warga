<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratAttachment extends Model
{
    use HasFactory;
    protected $table = 'surat_attachment';

    protected $fillable = [
        'id_surat',
        'id_user_warga',
        'fileKTP',
        'fileKK'
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d M Y');
    }
}
