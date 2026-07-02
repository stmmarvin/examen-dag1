<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            // Eigenaar-account waarmee de beoordelaar direct de CRUD kan testen.
            'name' => 'Eigenaar Kniploket Tiko',
            'email' => 'eigenaar@kniplokettiko.nl',
            'rolename' => 'eigenaar',
        ]);

        // Team-schema data voor de medewerker CRUD en de afspraakblokkade.
        DB::transaction(function (): void {
            DB::table('rollen')->insertOrIgnore([
                ['id' => 1, 'naam' => 'eigenaar', 'omschrijving' => 'Kan medewerkers beheren', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'naam' => 'klant', 'omschrijving' => 'Kan afspraken bekijken', 'created_at' => now(), 'updated_at' => now()],
            ]);

            $behandelingen = [
                ['id' => 1, 'naam' => 'Knippen', 'type' => 'Haar', 'beschrijving' => 'Knipbehandeling', 'duur_minuten' => 45, 'prijs' => 32.50, 'actief' => true],
                ['id' => 2, 'naam' => 'Kleuren', 'type' => 'Haar', 'beschrijving' => 'Kleurbehandeling', 'duur_minuten' => 90, 'prijs' => 68.00, 'actief' => true],
                ['id' => 3, 'naam' => 'Styling', 'type' => 'Haar', 'beschrijving' => 'Styling en föhnen', 'duur_minuten' => 40, 'prijs' => 29.95, 'actief' => true],
                ['id' => 4, 'naam' => 'Extensions', 'type' => 'Haar', 'beschrijving' => 'Extensions plaatsen', 'duur_minuten' => 120, 'prijs' => 110.00, 'actief' => true],
            ];

            foreach ($behandelingen as $behandeling) {
                DB::table('behandelingen')->updateOrInsert(
                    ['id' => $behandeling['id']],
                    $behandeling + ['created_at' => now(), 'updated_at' => now()]
                );
            }

            $medewerkers = [
                ['Lisa', 'Jansen', 'lisa@kniplokettiko.nl', '06 12345678', 'MW-001', 'Manager', '2021-01-10', [1, 2]],
                ['Laura', 'Jansen', 'laura@kniplokettiko.nl', '06 23456789', 'MW-002', 'Kapster', '2022-03-01', [1]],
                ['Mark', 'van Dijk', 'mark@kniplokettiko.nl', '06 34567890', 'MW-003', 'Colorist', '2023-04-15', [2]],
                ['Emma', 'Bakker', 'emma@kniplokettiko.nl', '06 45678901', 'MW-004', 'Stylist', '2024-02-20', [3]],
                ['Tom', 'Meijer', 'tom@kniplokettiko.nl', '06 56789012', 'MW-005', 'Extensions specialist', '2024-09-01', [4]],
            ];

            foreach ($medewerkers as $index => $data) {
                $gebruikerId = DB::table('gebruikers')->insertGetId([
                    'rol_id' => 1,
                    'voornaam' => $data[0],
                    'achternaam' => $data[1],
                    'email' => $data[2],
                    'telefoon' => $data[3],
                    'wachtwoord' => Hash::make('Welkom123!'),
                    'actief' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $medewerkerId = DB::table('medewerkers')->insertGetId([
                    'gebruiker_id' => $gebruikerId,
                    'personeelsnummer' => $data[4],
                    'functie' => $data[5],
                    'in_dienst_sinds' => $data[6],
                    'werkdagen' => 'Maandag t/m vrijdag',
                    'werktijden' => '09:00 - 17:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($data[7] as $behandelingId) {
                    DB::table('medewerker_behandeling')->insert([
                        'medewerker_id' => $medewerkerId,
                        'behandeling_id' => $behandelingId,
                    ]);
                }

                if ($index === 0) {
                    $klantGebruikerId = DB::table('gebruikers')->insertGetId([
                        'rol_id' => 2,
                        'voornaam' => 'Sanne',
                        'achternaam' => 'de Vries',
                        'email' => 'sanne@example.test',
                        'telefoon' => '06 67890123',
                        'wachtwoord' => Hash::make('Welkom123!'),
                        'actief' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $klantId = DB::table('klanten')->insertGetId([
                        'gebruiker_id' => $klantGebruikerId,
                        'plaats' => 'Utrecht',
                        'land' => 'Nederland',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    DB::table('afspraken')->insert([
                        'klant_id' => $klantId,
                        'medewerker_id' => $medewerkerId,
                        'start_datumtijd' => now()->addWeek(),
                        'eind_datumtijd' => now()->addWeek()->addHour(),
                        'status' => 'gepland',
                        'totaalprijs' => 32.50,
                        'aangemaakt_door_gebruiker_id' => $klantGebruikerId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
