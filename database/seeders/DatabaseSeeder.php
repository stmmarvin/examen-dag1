<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Treatment;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed data voor het medewerkeronderdeel binnen het bestaande schema.sql.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'eigenaar@kniplokettiko.nl'],
            [
                'name' => 'Eigenaar Kniploket Tiko',
                'password' => Hash::make('Eigenaar123!'),
                'rolename' => 'eigenaar',
            ],
        );

        DB::table('rollen')->updateOrInsert(
            ['naam' => 'eigenaar'],
            ['omschrijving' => 'Kan medewerkers beheren', 'created_at' => now(), 'updated_at' => now()],
        );

        DB::table('rollen')->updateOrInsert(
            ['naam' => 'klant'],
            ['omschrijving' => 'Kan afspraken bekijken', 'created_at' => now(), 'updated_at' => now()],
        );

        $eigenaarRolId = DB::table('rollen')->where('naam', 'eigenaar')->value('id');
        $klantRolId = DB::table('rollen')->where('naam', 'klant')->value('id');

        $behandelingen = [
            ['Knippen', 'Haar', 'Knippen en afwerken', 45, 32.50],
            ['Kleuren', 'Haar', 'Volledige kleurbehandeling', 90, 68.00],
            ['Styling', 'Haar', 'Stylen en föhnen', 40, 29.95],
            ['Extensions', 'Haar', 'Extensions plaatsen', 120, 110.00],
        ];

        foreach ($behandelingen as $behandeling) {
            DB::table('behandelingen')->updateOrInsert(
                ['naam' => $behandeling[0]],
                [
                    'type' => $behandeling[1],
                    'beschrijving' => $behandeling[2],
                    'duur_minuten' => $behandeling[3],
                    'prijs' => $behandeling[4],
                    'actief' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }

        $medewerkers = [
            ['MW-001', 'Lisa', 'Jansen', '06 12345678', 'lisa@kniplokettiko.nl', 'Manager', ['Knippen', 'Kleuren'], '2021-01-10'],
            ['MW-002', 'Laura', 'Jansen', '06 23456789', 'laura@kniplokettiko.nl', 'Kapster', ['Knippen'], '2022-03-01'],
            ['MW-003', 'Mark', 'van Dijk', '06 34567890', 'mark@kniplokettiko.nl', 'Colorist', ['Kleuren'], '2023-04-15'],
            ['MW-004', 'Emma', 'Bakker', '06 45678901', 'emma@kniplokettiko.nl', 'Stylist', ['Styling'], '2024-02-20'],
            ['MW-005', 'Tom', 'Meijer', '06 56789012', 'tom@kniplokettiko.nl', 'Extensions specialist', ['Extensions'], '2024-09-01'],
        ];

        foreach ($medewerkers as $medewerker) {
            DB::table('gebruikers')->updateOrInsert(
                ['email' => $medewerker[4]],
                [
                    'rol_id' => $eigenaarRolId,
                    'voornaam' => $medewerker[1],
                    'achternaam' => $medewerker[2],
                    'telefoon' => $medewerker[3],
                    'wachtwoord' => Hash::make('Welkom123!'),
                    'actief' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );

            $gebruikerId = DB::table('gebruikers')->where('email', $medewerker[4])->value('id');

            $medewerkerData = [
                'gebruiker_id' => $gebruikerId,
                'functie' => $medewerker[5],
                'in_dienst_sinds' => $medewerker[7],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (Schema::hasColumn('medewerkers', 'werkdagen')) {
                $medewerkerData['werkdagen'] = 'Maandag t/m vrijdag';
            }

            if (Schema::hasColumn('medewerkers', 'werktijden')) {
                $medewerkerData['werktijden'] = '09:00 - 17:00';
            }

            DB::table('medewerkers')->updateOrInsert(
                ['personeelsnummer' => $medewerker[0]],
                $medewerkerData,
            );

            $medewerkerId = DB::table('medewerkers')->where('personeelsnummer', $medewerker[0])->value('id');

            foreach ($medewerker[6] as $specialisatie) {
                $behandelingId = DB::table('behandelingen')->where('naam', $specialisatie)->value('id');

                DB::table('medewerker_behandeling')->updateOrInsert([
                    'medewerker_id' => $medewerkerId,
                    'behandeling_id' => $behandelingId,
                ]);
            }
        }

        $klantGebruikerId = DB::table('gebruikers')->updateOrInsert(
            ['email' => 'sanne@example.test'],
            [
                'rol_id' => $klantRolId,
                'voornaam' => 'Sanne',
                'achternaam' => 'de Vries',
                'telefoon' => '06 67890123',
                'wachtwoord' => Hash::make('Welkom123!'),
                'actief' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );

        $klantGebruikerId = DB::table('gebruikers')->where('email', 'sanne@example.test')->value('id');

        DB::table('klanten')->updateOrInsert(
            ['gebruiker_id' => $klantGebruikerId],
            [
                'plaats' => 'Utrecht',
                'land' => 'Nederland',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        );

        $lisaId = DB::table('medewerkers')->where('personeelsnummer', 'MW-001')->value('id');
        $klantId = DB::table('klanten')->where('gebruiker_id', $klantGebruikerId)->value('id');

        if ($lisaId && $klantId) {
            DB::table('afspraken')->updateOrInsert(
                ['klant_id' => $klantId, 'medewerker_id' => $lisaId, 'status' => 'gepland'],
                [
                    'start_datumtijd' => now()->addWeek(),
                    'eind_datumtijd' => now()->addWeek()->addHour(),
                    'totaalprijs' => 32.50,
                    'aangemaakt_door_gebruiker_id' => $klantGebruikerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
