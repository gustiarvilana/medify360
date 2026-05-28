<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian_360', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_target')->constrained('target_penilaian')->cascadeOnDelete();
            $table->foreignId('id_periode')->constrained('periode_penilaian')->cascadeOnDelete();
            $table->foreignId('id_penilai')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_dinilai')->constrained('users')->cascadeOnDelete();
            $table->decimal('skor_akhir', 5, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_360');
    }
};
