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
        Schema::create('monitoring_makanan_detail', function (Blueprint $table) {

            $table->id();

            // HEADER
            $table->unsignedBigInteger('monitoring_makanan_id');

            // SESUAI KUISIONER
            $table->enum('waktu_makan',[
                'Makan Pagi',
                'Snack Pagi',
                'Makan Siang',
                'Snack Siang',
                'Makan Malam',
                'Snack Malam'
            ]);

            // MAKANAN
            $table->string('nama_makanan');

            // PORSI
            $table->decimal('jumlah',5,2)->nullable();

            // SATUAN
            $table->string('satuan')->nullable();

            // KALORI
            $table->integer('kalori')->nullable();

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('monitoring_makanan_id')
                ->references('id')
                ->on('monitoring_makanan')
                ->onDelete('cascade');

            $table->index('monitoring_makanan_id');
            $table->index('waktu_makan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_makanan_detail');
    }
};
