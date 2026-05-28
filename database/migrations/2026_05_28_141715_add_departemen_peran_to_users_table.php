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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('id_departemen')->nullable()->constrained('departemen')->nullOnDelete();
            $table->foreignId('id_peran')->nullable()->constrained('peran')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_departemen');
            $table->dropConstrainedForeignId('id_peran');
        });
    }
};
