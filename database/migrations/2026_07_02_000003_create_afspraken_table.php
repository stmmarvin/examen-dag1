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

        Schema::create('afspraken', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medewerker_id')->constrained('medewerkers')->restrictOnDelete();
            $table->dateTime('starttijd')->index();
            $table->string('status', 40)->default('Gepland')->index();
            $table->timestamps();
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
