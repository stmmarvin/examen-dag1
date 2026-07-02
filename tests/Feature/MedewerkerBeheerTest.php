<?php

namespace Tests\Feature;

use App\Models\Afspraak;
use App\Models\Gebruiker;
use App\Models\Medewerker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MedewerkerBeheerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Acceptatiecriterium: verwijderen wordt geblokkeerd bij toekomstige afspraken.
     */
    public function test_medewerker_met_toekomstige_afspraak_kan_niet_worden_verwijderd(): void
    {
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
}
