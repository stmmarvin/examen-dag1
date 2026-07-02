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
        Schema::create('afspraken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medewerker_id')->constrained('medewerkers')->restrictOnDelete();
            $table->string('klantnaam', 120);
            $table->string('behandeling', 120);
            $table->dateTime('starttijd');
            $table->string('status', 40)->default('Gepland');
            $table->timestamps();

            $table->index(['medewerker_id', 'starttijd']);
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
