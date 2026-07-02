<?php

namespace Tests\Feature;

use App\Models\Afspraak;
use App\Models\Medewerker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $medewerker = Medewerker::create([
            'personeelsnummer' => 'MW-001',
            'voornaam' => 'Lisa',
            'achternaam' => 'Jansen',
            'telefoon' => '06 12345678',
            'email' => 'lisa@test.local',
            'functie' => 'Manager',
            'specialisaties' => ['Knippen', 'Kleuren'],
            'status' => 'In dienst',
            'in_dienst_sinds' => '2021-01-10',
            'werkdagen' => 'Maandag t/m vrijdag',
            'werktijden' => '09:00 - 17:00',
        ]);

        Afspraak::create([
            'medewerker_id' => $medewerker->id,
            'starttijd' => now()->addDay(),
            'status' => 'Gepland',
        ]);

        $response = $this->actingAs($eigenaar)->delete(route('medewerkers.destroy', $medewerker));

        $response->assertSessionHas('error', 'Deze medewerker kan niet worden verwijderd omdat er nog afspraken gepland staan');
        $this->assertDatabaseHas('medewerkers', ['id' => $medewerker->id]);
    }
}
