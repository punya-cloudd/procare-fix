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
        Schema::create('monitoring_makanan', function (Blueprint $table) {

            $table->id();

            // RELASI
            $table->unsignedBigInteger('peserta_id')->comment('Relasi ke tabel peserta');
            $table->unsignedBigInteger('petugas_id')->comment('Relasi ke tabel petugas');

            // TANGGAL MONITORING
            $table->date('tanggal');

            // HASIL
            $table->integer('total_kalori')->nullable()->comment('Total kalori seluruh makanan');
            $table->text('catatan')->nullable();

            // AUDIT
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('petugas')->onDelete('cascade');

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();

            // INDEX
            $table->index('peserta_id');
            $table->index('tanggal');

            // 1 peserta hanya boleh 1 monitoring per hari
            $table->unique(['peserta_id','tanggal']);

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_makanan');
    }
};
