<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guru_mapel', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_karyawan_id');
            $table->unsignedBigInteger('mata_pelajaran_id');
            $table->timestamps();

            $table->foreign('guru_karyawan_id')->references('id')->on('guru_karyawan');
            $table->foreign('mata_pelajaran_id')->references('id')->on('mata_pelajaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mapel');
    }
};
