<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Maak de persoonsgegevens los van de medewerkergegevens.
     */
    public function up(): void
    {
        Schema::create('personen', function (Blueprint $table) {
            $table->id();
            $table->string('voornaam', 80);
            $table->string('achternaam', 80);
            $table->string('telefoonnummer', 20);
            $table->string('emailadres')->unique();
            $table->timestamps();
        });
    }

    /**
     * Verwijder de tabel bij rollback van de dag 2 functionaliteit.
     */
    public function down(): void
    {
        Schema::dropIfExists('personen');
    }
};
