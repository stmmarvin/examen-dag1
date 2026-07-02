<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Maak de rol- en gebruikerstabellen uit het gezamenlijke databaseschema.
     */
    public function up(): void
    {
        Schema::create('rollen', function (Blueprint $table) {
            $table->id();
            $table->string('naam', 50)->unique();
            $table->string('omschrijving')->nullable();
            $table->timestamps();
        });

        Schema::create('gebruikers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rol_id')->constrained('rollen')->restrictOnDelete()->cascadeOnUpdate();
            $table->string('voornaam', 100);
            $table->string('achternaam', 100);
            $table->string('email')->unique();
            $table->string('telefoon', 30)->nullable();
            $table->string('wachtwoord');
            $table->boolean('actief')->default(true);
            $table->dateTime('laatste_login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Verwijder de tabellen in omgekeerde volgorde vanwege foreign keys.
     */
    public function down(): void
    {
        Schema::dropIfExists('gebruikers');
        Schema::dropIfExists('rollen');
    }
};
