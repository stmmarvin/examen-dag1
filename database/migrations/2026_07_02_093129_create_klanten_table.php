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
        Schema::create('klanten', function (Blueprint $table) {
            $table->id();
            $table->string('voornaam', 255);
            $table->string('achternaam', 255);
            $table->string('telefoonnummer', 20);
            $table->string('email', 255);
            $table->date('geboortedatum')->nullable();
            $table->string('adres', 255)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('woonplaats', 255)->nullable();
            $table->text('allergieen')->nullable();
            $table->text('wensen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klanten');
    }
};
