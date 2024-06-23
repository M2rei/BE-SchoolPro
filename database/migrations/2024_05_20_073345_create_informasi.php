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
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('guru_karyawan_id')->nullable();
            $table->string('judul');
            $table->text('isi');
            $table->string('kategori');
            $table->string('gambar');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('guru_karyawan_id')->references('id')->on('guru_karyawan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
