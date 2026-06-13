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
        Schema::create('m_satuan_obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_satuan');
            $table->string('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->comment('relasi ke table user');
            $table->unsignedBigInteger('updated_by')->comment('relasi ke table user');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_satuan_obat');
    }
};
