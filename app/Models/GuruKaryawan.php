<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GuruKaryawan extends Model
{
    use HasFactory;
    protected $table = 'guru_karyawan';
    protected $fillable = [
        'jabatan_id',
        'nama_guru',
        'nip',
        'nomor_telepon',
        'jenis_guru',
        'foto',
    ];

    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id' );
    }

    public function gurumapel(): BelongsToMany
    {
        return $this->belongsToMany(GuruMapel::class);
    }
}
