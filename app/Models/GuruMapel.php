<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class GuruMapel extends Model
{
    use HasFactory;
    protected $table = 'guru_mapel';
    protected $fillable = [
        'guru_karyawan_id',
        'mata_pelajaran_id'
    ];

    public function gurukaryawan(): BelongsToMany
    {
        return $this->belongsToMany(GuruKaryawan::class, 'guru_karyawan_id', 'id' );
    }
    public function matapelajaran(): BelongsToMany
    {
        return $this->belongsToMany(MataPelajaran::class, 'mata_pelajaran_id', 'id' );
    }
}
