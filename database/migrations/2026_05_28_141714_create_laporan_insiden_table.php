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
        Schema::create('laporan_insiden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelapor')->constrained('users');
            $table->string('tipe');
            $table->text('deskripsi');
            $table->string('status')->default('menunggu');
            $table->boolean('adalah_anonim')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_insiden');
    }
};
