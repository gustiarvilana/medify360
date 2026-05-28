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
        Schema::create('transaksi_cendol', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengirim')->constrained('users');
            $table->foreignId('id_penerima')->constrained('users');
            $table->string('kategori');
            $table->text('pesan')->nullable();
            $table->timestamp('waktu_transaksi')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_cendol');
    }
};
