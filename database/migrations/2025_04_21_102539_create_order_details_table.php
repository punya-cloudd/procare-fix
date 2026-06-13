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
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('obat_id');
            $table->integer('jumlah_obat');

            $table->foreign('order_id')->references('id')->on('trn_order')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('obat_id')->references('id')->on('m_obat')->onUpdate('cascade')->onDelete('cascade');

            // Composite primary key
            $table->primary(['order_id', 'obat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
    
};
