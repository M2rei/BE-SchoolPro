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
        Schema::create('akademik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kurikulum_id');
            $table->string('tahun_ajaran');
            $table->string('semester');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('deskripsi');
            $table->string('file_berkas');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('kurikulum_id')->references('id')->on('kurikulum')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akademik');
    }
};
