<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProfileSekolah extends Model
{
    use HasFactory;
    protected $table = 'profile_sekolah';
    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'nomor_telepon',
        'email',
        'kode_pos',
        'deskripsi_sejarah',
        'visi',
        'misi',
        'motto',
        'sambuatan_kepsek',
        'tujuan_sekolah',
        'logo_sekolah',
    ];
    public function akreditasi(): HasOne
    {
        return $this->hasOne(Akreditasi::class);
    }
    
}
