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
            $table->string('nik', 20)->nullable();
            $table->string('nama');
            $table->enum('jk', ['L', 'P']);
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();

            $table->enum('diagnosa', [
                'DM',
                'HIPERTENSI',
                'DM_HIPERTENSI'
            ]);

            $table->string('no_bpjs')->nullable();

            $table->enum('status', [
                'AKTIF',
                'TIDAK_AKTIF'
            ])->default('AKTIF');

            $table->timestamps();
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
