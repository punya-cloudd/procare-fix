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
        Schema::create('home_visit', function (Blueprint $table) {

            $table->id();

            // =====================
            // RELASI
            // =====================
            $table->foreignId('peserta_id')
                ->constrained('peserta')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('petugas_id')
                ->nullable()
                ->constrained('petugas')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            // =====================
            // AGENDA HOME VISIT
            // =====================

            $table->date('tanggal');

            $table->string('alasan')->nullable();

            $table->enum('jenis_kunjungan',[
                'Rutin',
                'Follow Up',
                'Edukasi',
                'Monitoring'
            ])->default('Rutin');

            $table->enum('status',[
                'Terjadwal',
                'Selesai',
                'Batal'
            ])->default('Terjadwal');


            // =====================
            // HASIL HOME VISIT
            // =====================

            $table->integer('sistol')->nullable();
            $table->integer('diastol')->nullable();
            $table->integer('nadi')->nullable();

            $table->decimal('berat_badan',5,2)->nullable();
            $table->decimal('tinggi_badan',5,2)->nullable();
            $table->decimal('bmi',5,2)->nullable();

            $table->integer('gds')->nullable();

            $table->enum('kepatuhan',[
                'Patuh',
                'Kurang Patuh',
                'Tidak Patuh'
            ])->nullable();

            $table->text('temuan_klinis')->nullable();

            $table->text('intervensi')->nullable();

            $table->text('edukasi')->nullable();

            $table->text('rencana_tindak_lanjut')->nullable();

            $table->text('catatan')->nullable();

            // Dokumentasi
            $table->string('foto')->nullable();

            // =====================
            // AUDIT
            // =====================

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamps();

            // INDEX
            $table->index('tanggal');
            $table->index('status');
            $table->index('peserta_id');
            $table->index('petugas_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_visit');
    }
};