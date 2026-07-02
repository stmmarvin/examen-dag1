<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $this->ensureMedewerkersTableExists();
        $this->ensureAfsprakenTableExists();

        if (! Schema::hasTable('behandeling_product')) {
            Schema::create('behandeling_product', function (Blueprint $table) {
                $table->id();
                $table->foreignId('behandeling_id')->constrained('behandelingen')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('product_id')->constrained('producten')->restrictOnDelete()->cascadeOnUpdate();
                $table->decimal('hoeveelheid', 10, 2)->default(1);
                $table->timestamps();

                $table->unique(['behandeling_id', 'product_id']);
                $table->index('product_id');
            });
        }

        if (! Schema::hasTable('medewerker_behandeling')) {
            Schema::create('medewerker_behandeling', function (Blueprint $table) {
                $table->id();
                $table->foreignId('medewerker_id')->constrained('medewerkers')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('behandeling_id')->constrained('behandelingen')->cascadeOnDelete()->cascadeOnUpdate();

                $table->unique(['medewerker_id', 'behandeling_id']);
                $table->index('behandeling_id');
            });
        }

        if (! Schema::hasTable('afspraak_behandeling')) {
            Schema::create('afspraak_behandeling', function (Blueprint $table) {
                $table->id();
                $table->foreignId('afspraak_id')->constrained('afspraken')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('behandeling_id')->constrained('behandelingen')->restrictOnDelete()->cascadeOnUpdate();
                $table->decimal('prijs_op_moment', 10, 2);
                $table->integer('duur_minuten_op_moment');
                $table->text('notitie')->nullable();
                $table->boolean('uitgevoerd')->default(false);
                $table->timestamps();

                $table->unique(['afspraak_id', 'behandeling_id']);
                $table->index('behandeling_id');
            });
        }
    }

    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        Schema::dropIfExists('afspraak_behandeling');
        Schema::dropIfExists('medewerker_behandeling');
        Schema::dropIfExists('behandeling_product');
    }

    private function ensureMedewerkersTableExists(): void
    {
        if (Schema::hasTable('medewerkers')) {
            return;
        }

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

    private function ensureAfsprakenTableExists(): void
    {
        if (Schema::hasTable('afspraken')) {
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
};
