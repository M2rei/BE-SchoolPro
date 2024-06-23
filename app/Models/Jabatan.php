<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Jabatan extends Model
{
    use HasFactory;
    protected $table = 'jabatan';
    protected $fillable = [
        'nama_jabatan',
        'deskripsi',
    ];

    public function gurukaryawan(): HasOne
    {
        return $this->hasOne(GuruKaryawan::class, 'jabatan_id', 'id');
    }
}
