<?php

namespace Tests\Feature;

use App\Models\Afspraak;
use App\Models\Gebruiker;
use App\Models\Medewerker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MedewerkerBeheerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Acceptatiecriterium: verwijderen wordt geblokkeerd bij toekomstige afspraken.
     */
    public function test_medewerker_met_toekomstige_afspraak_kan_niet_worden_verwijderd(): void
    {
        $this->maakMedewerkerTabellenVoorTest();

        $eigenaar = User::factory()->create(['rolename' => 'eigenaar']);

        DB::table('rollen')->insert([
            ['id' => 1, 'naam' => 'eigenaar', 'omschrijving' => 'Kan medewerkers beheren'],
            ['id' => 2, 'naam' => 'klant', 'omschrijving' => 'Kan afspraken bekijken'],
        ]);

        $gebruiker = Gebruiker::create([
            'rol_id' => 1,
            'voornaam' => 'Lisa',
            'achternaam' => 'Jansen',
            'email' => 'lisa@test.local',
            'telefoon' => '06 12345678',
            'wachtwoord' => Hash::make('Welkom123!'),
            'actief' => true,
        ]);

        $medewerker = Medewerker::create([
            'gebruiker_id' => $gebruiker->id,
            'personeelsnummer' => 'MW-001',
            'functie' => 'Manager',
            'in_dienst_sinds' => '2021-01-10',
        ]);

        $klantGebruikerId = DB::table('gebruikers')->insertGetId([
            'rol_id' => 2,
            'voornaam' => 'Sanne',
            'achternaam' => 'de Vries',
            'email' => 'sanne@test.local',
            'telefoon' => '06 87654321',
            'wachtwoord' => Hash::make('Welkom123!'),
            'actief' => true,
        ]);

        $klantId = DB::table('klanten')->insertGetId([
            'gebruiker_id' => $klantGebruikerId,
            'plaats' => 'Utrecht',
            'land' => 'Nederland',
        ]);

        Afspraak::create([
            'klant_id' => $klantId,
            'medewerker_id' => $medewerker->id,
            'start_datumtijd' => now()->addDay(),
            'eind_datumtijd' => now()->addDay()->addHour(),
            'status' => 'gepland',
            'totaalprijs' => 32.50,
        ]);

        $response = $this->actingAs($eigenaar)->delete(route('medewerkers.destroy', $medewerker));

        $response->assertSessionHas('error', 'Deze medewerker kan niet worden verwijderd omdat er nog afspraken gepland staan');
        $this->assertDatabaseHas('medewerkers', ['id' => $medewerker->id]);
    }

    /**
     * De echte applicatie gebruikt schema.sql in MySQL; deze test maakt alleen de minimale tabellen aan.
     */
    private function maakMedewerkerTabellenVoorTest(): void
    {
        Schema::create('rollen', function (Blueprint $table): void {
            $table->id();
            $table->string('naam')->unique();
            $table->string('omschrijving')->nullable();
            $table->timestamps();
        });

        Schema::create('gebruikers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('rol_id')->constrained('rollen');
            $table->string('voornaam');
            $table->string('achternaam');
            $table->string('email')->unique();
            $table->string('telefoon')->nullable();
            $table->string('wachtwoord');
            $table->boolean('actief')->default(true);
            $table->timestamp('laatste_login')->nullable();
            $table->timestamps();
        });

        Schema::create('medewerkers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('gebruiker_id')->constrained('gebruikers')->cascadeOnDelete();
            $table->string('personeelsnummer')->unique();
            $table->string('functie')->nullable();
            $table->date('in_dienst_sinds')->nullable();
            $table->string('werkdagen')->default('Maandag t/m vrijdag');
            $table->string('werktijden')->default('09:00 - 17:00');
            $table->text('notities')->nullable();
            $table->timestamps();
        });

        Schema::create('klanten', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('gebruiker_id')->constrained('gebruikers')->cascadeOnDelete();
            $table->string('plaats')->nullable();
            $table->string('land')->default('Nederland');
            $table->timestamps();
        });

        Schema::create('afspraken', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('klant_id')->constrained('klanten');
            $table->foreignId('medewerker_id')->nullable()->constrained('medewerkers')->nullOnDelete();
            $table->dateTime('start_datumtijd');
            $table->dateTime('eind_datumtijd');
            $table->string('status')->default('gepland');
            $table->decimal('totaalprijs', 10, 2)->default(0);
            $table->timestamps();
        });
    }
}
