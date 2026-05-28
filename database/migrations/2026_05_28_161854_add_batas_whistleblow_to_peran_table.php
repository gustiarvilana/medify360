<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBatasWhistleblowToPeranTable extends Migration
{
    public function up(): void
    {
        Schema::table('peran', function (Blueprint $table) {
            $table->unsignedSmallInteger('batas_whistleblow')->nullable()->default(5)->after('nama');
        });
    }

    public function down(): void
    {
        Schema::table('peran', function (Blueprint $table) {
            $table->dropColumn('batas_whistleblow');
        });
    }
}
