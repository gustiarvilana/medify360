<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_periode')->constrained('periode_penilaian')->cascadeOnDelete();
            $table->foreignId('id_penilai')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_dinilai')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'selesai'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_penilaian');
    }
};
