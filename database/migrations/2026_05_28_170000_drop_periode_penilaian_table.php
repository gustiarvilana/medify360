<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('penilaian_360', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });

        Schema::table('target_penilaian', function (Blueprint $table) {
            $table->dropForeign(['id_periode']);
            $table->dropColumn('id_periode');
        });

        Schema::dropIfExists('periode_penilaian');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('periode_penilaian', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['draft', 'aktif', 'selesai'])->default('draft');
            $table->timestamps();
        });

        Schema::table('target_penilaian', function (Blueprint $table) {
            $table->foreignId('id_periode')->nullable()->constrained('periode_penilaian')->cascadeOnDelete();
        });

        Schema::table('penilaian_360', function (Blueprint $table) {
            $table->foreignId('id_periode')->nullable()->constrained('periode_penilaian')->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }
};
