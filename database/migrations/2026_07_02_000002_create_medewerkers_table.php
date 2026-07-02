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
        if (Schema::hasTable('medewerkers')) {
            return;
        }

        Schema::create('medewerkers', function (Blueprint $table) {
            $table->id();
            $table->string('personeelsnummer', 50)->unique();
            $table->string('voornaam', 80);
            $table->string('achternaam', 80);
            $table->string('telefoon', 30);
            $table->string('email')->unique();
            $table->string('functie', 100)->nullable();
            $table->json('specialisaties');
            $table->string('status', 40)->default('In dienst');
            $table->date('in_dienst_sinds')->nullable();
            $table->string('werkdagen', 120)->default('Maandag t/m vrijdag');
            $table->string('werktijden', 40)->default('09:00 - 17:00');
            $table->text('notities')->nullable();
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
