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
     * Seed alleen data voor het medewerkeronderdeel.
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

        $medewerkers = [
            ['MW-001', 'Lisa', 'Jansen', '06 12345678', 'lisa@kniplokettiko.nl', 'Manager', ['Knippen', 'Kleuren'], '2021-01-10'],
            ['MW-002', 'Laura', 'Jansen', '06 23456789', 'laura@kniplokettiko.nl', 'Kapster', ['Knippen'], '2022-03-01'],
            ['MW-003', 'Mark', 'van Dijk', '06 34567890', 'mark@kniplokettiko.nl', 'Colorist', ['Kleuren'], '2023-04-15'],
            ['MW-004', 'Emma', 'Bakker', '06 45678901', 'emma@kniplokettiko.nl', 'Stylist', ['Styling'], '2024-02-20'],
            ['MW-005', 'Tom', 'Meijer', '06 56789012', 'tom@kniplokettiko.nl', 'Extensions specialist', ['Extensions'], '2024-09-01'],
        ];

        foreach ($medewerkers as $medewerker) {
            DB::table('medewerkers')->updateOrInsert(
                ['personeelsnummer' => $medewerker[0]],
                [
                    'voornaam' => $medewerker[1],
                    'achternaam' => $medewerker[2],
                    'telefoon' => $medewerker[3],
                    'email' => $medewerker[4],
                    'functie' => $medewerker[5],
                    'specialisaties' => json_encode($medewerker[6]),
                    'status' => 'In dienst',
                    'in_dienst_sinds' => $medewerker[7],
                    'werkdagen' => 'Maandag t/m vrijdag',
                    'werktijden' => '09:00 - 17:00',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }

        // Alleen voor de acceptatie-eis: Lisa kan niet verwijderd worden door toekomstige planning.
        $lisaId = DB::table('medewerkers')->where('personeelsnummer', 'MW-001')->value('id');

        if ($lisaId) {
            DB::table('afspraken')->updateOrInsert(
                ['medewerker_id' => $lisaId, 'status' => 'Gepland'],
                [
                    'starttijd' => now()->addWeek(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
