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
        Schema::create('m_obat', function (Blueprint $table) {
            $table->id();
            $table->char('nama_obat', length: 100)->unique();
            $table->unsignedBigInteger('satuan_id')->comment('relasi ke table m_satuan_obat');
            $table->unsignedBigInteger('gudang_id')->comment('relasi ke table m_kategori_obat');
            $table->integer('stok')->default(0);
            $table->tinyInteger('jenis_obat')->default(1)->comment('0 = tidak ada, 1 = injeksi, 2 = oral');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->char('bpom')->nullable();
            $table->string('gambar_obat')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('created_by')->comment('relasi ke table useR');
            $table->unsignedBigInteger('updated_by')->comment('relasi ke table user');
            $table->timestamps();
            
            $table->foreign('gudang_id')->references('id')->on('m_gudang')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('satuan_id')->references('id')->on('m_satuan_obat')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_obat');
    }
};
