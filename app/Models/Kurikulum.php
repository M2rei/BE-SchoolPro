<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kurikulum extends Model
{
    use HasFactory;
    protected $table = 'kurikulum';
    protected $fillable = [
        'jenis_kurikulum',
        'deskripsi',
        'file_kurikulum',
    ];

    public function kurikulum(): HasOne
    {
        return $this->hasOne(Kurikulum::class );
    }
}
