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
            $table->foreignId('gebruiker_id')->constrained('gebruikers')->onDelete('cascade');
            $table->date('geboortedatum')->nullable();
            $table->string('adresregel1', 255)->nullable();
            $table->string('adresregel2', 255)->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('plaats', 255)->nullable();
            $table->string('land', 100)->nullable();
            $table->text('algemene_notities')->nullable();
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
