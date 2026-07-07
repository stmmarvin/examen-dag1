<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Voeg velden toe die het medewerker-wireframe nodig heeft als ze ontbreken.
     */
    public function up(): void
    {
        if (! Schema::hasTable('medewerkers')) {
            return;
        }

        Schema::table('medewerkers', function (Blueprint $table) {
            if (! Schema::hasColumn('medewerkers', 'werkdagen')) {
                $table->string('werkdagen', 120)->default('Maandag t/m vrijdag')->after('in_dienst_sinds');
            }

            if (! Schema::hasColumn('medewerkers', 'werktijden')) {
                $table->string('werktijden', 40)->default('09:00 - 17:00')->after('werkdagen');
            }

            if (! Schema::hasColumn('medewerkers', 'notities')) {
                $table->text('notities')->nullable()->after('werktijden');
            }
        });
    }

    /**
     * Laat bestaande teamkolommen bij rollback ongemoeid.
     */
    public function down(): void
    {
        // Bewust leeg: deze migration vult ontbrekende wireframevelden aan.
    }
};
