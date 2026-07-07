<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('behandelingen', function (Blueprint $table) {
            $table->string('afbeelding_pad')->nullable()->after('beschrijving');
        });
    }

    public function down(): void
    {
        Schema::table('behandelingen', function (Blueprint $table) {
            $table->dropColumn('afbeelding_pad');
        });
    }
};
