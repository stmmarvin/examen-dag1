<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Afspraken zijn nodig om verwijderen met toekomstige planning te blokkeren.
     */
    public function up(): void
    {
        if (Schema::hasTable('afspraken')) {
            return;
        }

        if (! Schema::hasTable('klanten')) {
            return;
        }

        Schema::create('afspraken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klant_id')->constrained('klanten')->restrictOnDelete()->cascadeOnUpdate();
            $table->foreignId('medewerker_id')->nullable()->constrained('medewerkers')->nullOnDelete()->cascadeOnUpdate();
            $table->dateTime('start_datumtijd')->index();
            $table->dateTime('eind_datumtijd');
            $table->enum('status', ['gepland', 'bevestigd', 'uitgevoerd', 'geannuleerd', 'no_show'])->default('gepland')->index();
            $table->text('opmerking_klant')->nullable();
            $table->text('interne_notitie')->nullable();
            $table->decimal('totaalprijs', 10, 2)->default(0);
            $table->foreignId('aangemaakt_door_gebruiker_id')->nullable()->constrained('gebruikers')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->index(['medewerker_id', 'start_datumtijd']);
        });
    }

    /**
     * Verwijder afspraken bij rollback van de dag 2 tabellen.
     */
    public function down(): void
    {
        Schema::dropIfExists('afspraken');
    }
};
