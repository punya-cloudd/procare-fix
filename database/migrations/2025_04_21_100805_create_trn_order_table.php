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
        Schema::create('trn_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_layanan_id');
            $table->unsignedBigInteger('user_id');
            $table->date('tgl_order')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=Menunggu, 1=Di Proses, 2=Selesai');
            $table->time('jam_order')->nullable();
            $table->unsignedBigInteger('created_by')->comment('relasi ke table useR');
            $table->unsignedBigInteger('updated_by')->comment('relasi ke table user');
            $table->timestamps();

            $table->foreign('unit_layanan_id')->references('id')->on('m_unit_layanan')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trn_order');
    }
};
