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
        Schema::create('akreditasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_sekolah_id');
            $table->string('npsn');
            $table->string('status');
            $table->string('bentuk_pendidikan');
            $table->string('status_kepemilikan');
            $table->string('sk_pendirian_sekolah');
            $table->date('tanggal_sk_pendirian');
            $table->string('sk_izin_operasional');
            $table->date('tanggal_sk_izin_operasional');
            $table->string('akreditasi');
            $table->string('file_berkas_akreditasi');
            $table->timestamps();

            $table->foreign('profile_sekolah_id')->references('id')->on('profile_sekolah')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akreditasi');
    }
};
