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
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('no_bpjs')->nullable()->unique();
            $table->string('nik', 20)->nullable()->unique();
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->unsignedBigInteger('dokter_id')->nullable()->comment('Relasi ke tabel dokter');
            $table->unsignedBigInteger('jenis_penyakit_id')->nullable()->comment('Relasi ke tabel jenis_penyakit');
            $table->enum('status', ['AKTIF', 'TIDAK_AKTIF'])->default('AKTIF');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('dokter_id')->references('id')->on('dokter')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('jenis_penyakit_id')->references('id')->on('jenis_penyakit')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta');
    }
};
