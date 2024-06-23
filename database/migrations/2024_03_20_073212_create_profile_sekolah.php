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
        Schema::create('profile_sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('alamat');
            $table->string('nomor_telepon');
            $table->string('email');
            $table->string('kode_pos');

            $table->text('deskripsi_sejarah');
            $table->text('visi');
            $table->text('misi');
            $table->string('motto');
            $table->text('sambuatan_kepsek');
            $table->string('tujuan_sekolah');
            $table->string('logo_sekolah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_sekolah');
    }
};
