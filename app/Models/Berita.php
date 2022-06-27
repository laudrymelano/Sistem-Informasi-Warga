<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;
    protected $table = 'berita';
    protected $fillable = [
        'judul',
        'thumbnail',
        'gambar1',
        'gambar2',
        'attachment',
        'content',
        'created_at'
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->translatedFormat('l, d M Y');
    }
}
