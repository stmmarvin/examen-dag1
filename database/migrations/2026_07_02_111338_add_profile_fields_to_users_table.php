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
            $table->date('geboortedatum')->nullable()->after('telefoon');
            $table->string('adres')->nullable()->after('geboortedatum');
            $table->string('postcode', 10)->nullable()->after('adres');
            $table->string('plaats')->nullable()->after('postcode');
            $table->text('allergieen')->nullable()->after('plaats');
            $table->text('wensen')->nullable()->after('allergieen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['geboortedatum', 'adres', 'postcode', 'plaats', 'allergieen', 'wensen']);
        });
    }
};
