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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->unsignedBigInteger('peserta_id')->comment('Relasi ke tabel peserta');
            $table->unsignedBigInteger('petugas_id')->comment('Relasi ke tabel petugas');
            $table->date('tanggal');

            // VITAL
            $table->integer('sistol')->nullable();
            $table->integer('diastol')->nullable();
            $table->integer('nadi')->nullable();
            $table->integer('spo2')->nullable();

            // ANTROPOMETRI
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            $table->decimal('lingkar_perut', 5, 2)->nullable();

            // KELUHAN
            $table->text('keluhan')->nullable();
            $table->string('kepatuhan')->nullable();

            // GLIKEMIK
            $table->integer('gds')->nullable();
            $table->integer('gdp')->nullable();
            $table->integer('g2jpp')->nullable();
            $table->decimal('hba1c', 5, 2)->nullable();

            // LIPID
            $table->integer('kolesterol_total')->nullable();
            $table->integer('ldl')->nullable();
            $table->integer('hdl')->nullable();
            $table->integer('trigliserida')->nullable();

            // GINJAL
            $table->integer('ureum')->nullable();
            $table->decimal('kreatinin', 5, 2)->nullable();
            $table->integer('egfr')->nullable();
            $table->integer('asam_urat')->nullable();

            // HASIL
            $table->text('hasil_lab')->nullable();
            $table->text('catatan')->nullable();

            // DOKUMEN PEMERIKSAAN
            $table->string('dokumen')->nullable()->comment('Path file PDF/JPG/PNG pemeriksaan');

            // RISK SYSTEM
            $table->unsignedTinyInteger('risk_score')->default(0);
            $table->string('risk_level')->nullable();
            $table->json('risk_breakdown')->nullable();

            // AUDIT
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('peserta_id')->references('id')->on('peserta')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('petugas_id')->references('id')->on('petugas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');

            // INDEX
            $table->index('peserta_id');
            $table->index('tanggal');
            $table->index('risk_score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
