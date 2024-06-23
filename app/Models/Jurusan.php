<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;
    protected $table = 'jurusan';
    protected $fillable = [
        'nama_jurusan',
        'deskripsi',
    ];

    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class, 'jurusan_id', 'id');
    }
}
