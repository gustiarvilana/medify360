<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skor_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penilaian')->constrained('penilaian_360')->cascadeOnDelete();
            $table->foreignId('id_dimensi')->constrained('dimensi_penilaian')->cascadeOnDelete();
            $table->unsignedTinyInteger('skor'); // 1-5
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skor_penilaian');
    }
};
