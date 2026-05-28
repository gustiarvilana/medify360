<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bobot_relasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peran_penilai')->constrained('peran')->cascadeOnDelete();
            $table->foreignId('id_peran_dinilai')->constrained('peran')->cascadeOnDelete();
            $table->decimal('bobot', 5, 2)->default(1.00);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobot_relasi');
    }
};
