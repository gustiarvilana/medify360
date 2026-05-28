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
        Schema::table('laporan_insiden', function (Blueprint $table) {
            $table->foreignId('id_penerima')->nullable()->constrained('users')->nullOnDelete()->after('id_pelapor');
        });
    }

    public function down(): void
    {
        Schema::table('laporan_insiden', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_penerima');
        });
    }
};
