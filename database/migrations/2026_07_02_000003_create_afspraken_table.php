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
        Schema::create('klanten', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gebruiker_id')->unique()->constrained('gebruikers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('geboortedatum')->nullable();
            $table->string('adresregel1')->nullable();
            $table->string('adresregel2')->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('plaats', 100)->nullable()->index();
            $table->string('land', 100)->nullable();
            $table->text('algemene_notities')->nullable();
            $table->timestamps();
        });

        Schema::create('behandelingen', function (Blueprint $table) {
            $table->id();
            $table->string('naam', 150)->index();
            $table->string('type', 100)->index();
            $table->text('beschrijving')->nullable();
            $table->integer('duur_minuten');
            $table->decimal('prijs', 10, 2);
            $table->boolean('actief')->default(true);
            $table->timestamps();
        });

        Schema::create('medewerker_behandeling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medewerker_id')->constrained('medewerkers')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('behandeling_id')->constrained('behandelingen')->cascadeOnDelete()->cascadeOnUpdate();
        });

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
        Schema::dropIfExists('medewerker_behandeling');
        Schema::dropIfExists('behandelingen');
        Schema::dropIfExists('klanten');
    }
};
