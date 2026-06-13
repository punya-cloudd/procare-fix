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
        Schema::create('histori_stok_obat', function (Blueprint $table) {
            // Kolom utama
            $table->id(); // Primary key
            $table->unsignedBigInteger('obat_id'); // Foreign key ke tabel m_obat
            $table->unsignedBigInteger('order_id')->nullable(); // Foreign key ke tabel trn_order (opsional)
            $table->date('tanggal_masuk')->nullable(); // Tanggal barang masuk (opsional)
            $table->date('tanggal_keluar')->nullable(); // Tanggal barang keluar (opsional)
            $table->integer('jumlah_awal')->default(0); // Jumlah stok awal
            $table->integer('jumlah_baru')->default(0); // Jumlah yang ditambahkan/dikurangi
            $table->integer('jumlah_akhir')->default(0); // Jumlah stok akhir
            $table->timestamps(); // Kolom created_at dan updated_at

            // Relasi foreign key
            $table->foreign('obat_id')
                ->references('id')
                ->on('m_obat') // Nama tabel obat
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')
                ->on('trn_order') // Nama tabel order
                ->onUpdate('cascade')
                ->onDelete('set null'); // Mengatur nilai menjadi NULL jika order dihapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histori_stok_obat');
    }
};
