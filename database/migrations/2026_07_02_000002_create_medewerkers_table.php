<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Maak de werkgegevens die in de medewerker-wireframes getoond worden.
     */
    public function up(): void
    {
        Schema::create('medewerkers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebruiker_id')->unique()->constrained('gebruikers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('personeelsnummer', 50)->unique();
            $table->string('functie', 100)->nullable();
            $table->date('in_dienst_sinds')->nullable();
            $table->string('werkdagen', 120)->default('Maandag t/m vrijdag');
            $table->string('werktijden', 40)->default('09:00 - 17:00');
            $table->text('notities')->nullable();
            $table->timestamps();

            $table->index('functie');
        });
    }

    /**
     * Verwijder de medewerkergegevens bij rollback.
     */
    public function down(): void
    {
        Schema::dropIfExists('medewerkers');
    }
};
