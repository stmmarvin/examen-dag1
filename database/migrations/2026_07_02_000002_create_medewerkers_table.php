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
            $table->foreignId('persoon_id')->constrained('personen')->cascadeOnDelete();
            $table->string('functie', 80);
            $table->json('specialisaties');
            $table->string('status', 40)->default('In dienst');
            $table->date('startdatum')->nullable();
            $table->string('werkdagen', 120)->default('Maandag t/m vrijdag');
            $table->string('werktijden', 40)->default('09:00 - 17:00');
            $table->timestamps();

            $table->index(['status', 'functie']);
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
