<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Akreditasi extends Model
{
    use HasFactory;
    protected $table = 'akreditasi';
    protected $fillable = [
        'profile_sekolah_id',
        'npsn',
        'status',
        'bentuk_pendidikan', 
        'status_kepemilikan',
        'sk_pendirian_sekolah',
        'tanggal_sk_pendirian',
        'sk_izin_operasional',
        'tanggal_sk_izin_operasional',
        'akreditasi',
        'file_berkas_akreditasi',
    ];

    public function profilesekolah(): BelongsTo
    {
        return $this->belongsTo(ProfileSekolah::class, 'profile_sekolah_id', 'id' );
    }

}
