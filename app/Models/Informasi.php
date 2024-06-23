<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Informasi extends Model
{
    use HasFactory;
    protected $table = 'informasi';
    protected $fillable = [
        'users_id',
        'guru_karyawan_id',
        'judul',
        'isi',
        'kategori',
        'gambar',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function gurukaryawan(): BelongsTo
    {
        return $this->belongsTo(GuruKaryawan::class, 'guru_karyawan_id', 'id');
    }
}
