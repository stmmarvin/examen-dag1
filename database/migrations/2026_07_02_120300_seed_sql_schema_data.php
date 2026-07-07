<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $now = now();

        $rollen = [
            ['naam' => 'eigenaar', 'omschrijving' => 'Kan medewerkers beheren'],
            ['naam' => 'medewerker', 'omschrijving' => 'Kan klanten, afspraken en behandelingen beheren'],
            ['naam' => 'klant', 'omschrijving' => 'Kan afspraken bekijken en beheren'],
            ['naam' => 'planner', 'omschrijving' => 'Kan afspraken plannen en wijzigen'],
            ['naam' => 'beheerder', 'omschrijving' => 'Kan technische instellingen beheren'],
        ];

        foreach ($rollen as $rol) {
            DB::table('rollen')->updateOrInsert(
                ['naam' => $rol['naam']],
                ['omschrijving' => $rol['omschrijving'], 'created_at' => $now, 'updated_at' => $now],
            );
        }

        $rolIds = DB::table('rollen')->pluck('id', 'naam');

        $gebruikers = [
            ['rol' => 'eigenaar', 'voornaam' => 'Eigenaar', 'achternaam' => 'Kniploket', 'email' => 'Eigenaar123!?@gmail.com', 'telefoon' => null, 'wachtwoord' => '$2y$12$bcVdb.CEICnkUoWtGb1fDOHBE3DD8g8memRlcY9mQea8/OHQyvx8y'],
            ['rol' => 'eigenaar', 'voornaam' => 'Lisa', 'achternaam' => 'Jansen', 'email' => 'lisa@kniplokettiko.nl', 'telefoon' => '06 12345678', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'medewerker', 'voornaam' => 'Laura', 'achternaam' => 'Jansen', 'email' => 'laura@kniplokettiko.nl', 'telefoon' => '06 23456789', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'medewerker', 'voornaam' => 'Mark', 'achternaam' => 'van Dijk', 'email' => 'mark@kniplokettiko.nl', 'telefoon' => '06 34567890', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'medewerker', 'voornaam' => 'Emma', 'achternaam' => 'Bakker', 'email' => 'emma@kniplokettiko.nl', 'telefoon' => '06 45678901', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'medewerker', 'voornaam' => 'Tom', 'achternaam' => 'Meijer', 'email' => 'tom@kniplokettiko.nl', 'telefoon' => '06 56789012', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'klant', 'voornaam' => 'Sanne', 'achternaam' => 'de Vries', 'email' => 'sanne@example.test', 'telefoon' => '06 67890123', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'klant', 'voornaam' => 'Nora', 'achternaam' => 'Peters', 'email' => 'nora@example.test', 'telefoon' => '06 78901234', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'klant', 'voornaam' => 'Mila', 'achternaam' => 'Vos', 'email' => 'mila@example.test', 'telefoon' => '06 89012345', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'klant', 'voornaam' => 'Daan', 'achternaam' => 'Smit', 'email' => 'daan@example.test', 'telefoon' => '06 90123456', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
            ['rol' => 'klant', 'voornaam' => 'Yara', 'achternaam' => 'Mulder', 'email' => 'yara@example.test', 'telefoon' => '06 01234567', 'wachtwoord' => '$2y$12$voorbeeldhashhier'],
        ];

        foreach ($gebruikers as $gebruiker) {
            DB::table('gebruikers')->updateOrInsert(
                ['email' => $gebruiker['email']],
                [
                    'rol_id' => $rolIds[$gebruiker['rol']],
                    'voornaam' => $gebruiker['voornaam'],
                    'achternaam' => $gebruiker['achternaam'],
                    'telefoon' => $gebruiker['telefoon'],
                    'wachtwoord' => $gebruiker['wachtwoord'],
                    'actief' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }

        $gebruikerIds = DB::table('gebruikers')->pluck('id', 'email');

        $medewerkers = [
            ['email' => 'lisa@kniplokettiko.nl', 'personeelsnummer' => 'MW-001', 'functie' => 'Manager', 'in_dienst_sinds' => '2021-01-10', 'werkdagen' => 'Maandag t/m vrijdag', 'werktijden' => '09:00 - 17:00'],
            ['email' => 'laura@kniplokettiko.nl', 'personeelsnummer' => 'MW-002', 'functie' => 'Kapster', 'in_dienst_sinds' => '2022-03-01', 'werkdagen' => 'Maandag t/m donderdag', 'werktijden' => '09:00 - 17:00'],
            ['email' => 'mark@kniplokettiko.nl', 'personeelsnummer' => 'MW-003', 'functie' => 'Colorist', 'in_dienst_sinds' => '2023-04-15', 'werkdagen' => 'Dinsdag t/m zaterdag', 'werktijden' => '10:00 - 18:00'],
            ['email' => 'emma@kniplokettiko.nl', 'personeelsnummer' => 'MW-004', 'functie' => 'Stylist', 'in_dienst_sinds' => '2024-02-20', 'werkdagen' => 'Maandag, woensdag, vrijdag', 'werktijden' => '09:00 - 16:00'],
            ['email' => 'tom@kniplokettiko.nl', 'personeelsnummer' => 'MW-005', 'functie' => 'Extensions specialist', 'in_dienst_sinds' => '2024-09-01', 'werkdagen' => 'Woensdag t/m zaterdag', 'werktijden' => '10:00 - 18:00'],
        ];

        foreach ($medewerkers as $medewerker) {
            DB::table('medewerkers')->updateOrInsert(
                ['personeelsnummer' => $medewerker['personeelsnummer']],
                [
                    'gebruiker_id' => $gebruikerIds[$medewerker['email']],
                    'functie' => $medewerker['functie'],
                    'in_dienst_sinds' => $medewerker['in_dienst_sinds'],
                    'werkdagen' => $medewerker['werkdagen'],
                    'werktijden' => $medewerker['werktijden'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }

        $klanten = [
            ['email' => 'tom@kniplokettiko.nl', 'geboortedatum' => '1998-06-15', 'adresregel1' => 'Voorbeeldstraat 1', 'postcode' => '1234AB', 'plaats' => 'Utrecht', 'land' => 'Nederland', 'algemene_notities' => 'Parfumvrij werken'],
            ['email' => 'sanne@example.test', 'geboortedatum' => '1989-11-03', 'adresregel1' => 'Kapsalonlaan 7', 'postcode' => '3521CD', 'plaats' => 'Utrecht', 'land' => 'Nederland', 'algemene_notities' => 'Komt graag in de ochtend'],
            ['email' => 'nora@example.test', 'geboortedatum' => '2001-02-21', 'adresregel1' => 'Knipstraat 12', 'postcode' => '3512EF', 'plaats' => 'Nieuwegein', 'land' => 'Nederland', 'algemene_notities' => 'Studentenkorting'],
            ['email' => 'mila@example.test', 'geboortedatum' => '1977-08-09', 'adresregel1' => 'Kleurplein 4', 'postcode' => '3581GH', 'plaats' => 'Zeist', 'land' => 'Nederland', 'algemene_notities' => 'Gevoelige hoofdhuid'],
            ['email' => 'daan@example.test', 'geboortedatum' => '1995-12-30', 'adresregel1' => 'Stylinghof 22', 'postcode' => '3701JK', 'plaats' => 'Houten', 'land' => 'Nederland', 'algemene_notities' => 'Wil vaste stylist'],
        ];

        foreach ($klanten as $klant) {
            DB::table('klanten')->updateOrInsert(
                ['gebruiker_id' => $gebruikerIds[$klant['email']]],
                [
                    'geboortedatum' => $klant['geboortedatum'],
                    'adresregel1' => $klant['adresregel1'],
                    'postcode' => $klant['postcode'],
                    'plaats' => $klant['plaats'],
                    'land' => $klant['land'],
                    'algemene_notities' => $klant['algemene_notities'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }

        $producten = [
            ['naam' => 'Shampoo Hydrate', 'sku' => 'PRD-001', 'beschrijving' => 'Hydraterende shampoo', 'voorraad_aantal' => 25, 'eenheid' => 'fles', 'kostprijs' => 4.50, 'verkoopprijs' => 9.95],
            ['naam' => 'Kleurcreme Bruin', 'sku' => 'PRD-002', 'beschrijving' => 'Professionele kleurcreme', 'voorraad_aantal' => 40, 'eenheid' => 'tube', 'kostprijs' => 5.75, 'verkoopprijs' => 14.95],
            ['naam' => 'Styling Mousse', 'sku' => 'PRD-003', 'beschrijving' => 'Mousse voor volume', 'voorraad_aantal' => 18, 'eenheid' => 'bus', 'kostprijs' => 3.20, 'verkoopprijs' => 8.95],
            ['naam' => 'Extensions Tape', 'sku' => 'PRD-004', 'beschrijving' => 'Tape voor extensions', 'voorraad_aantal' => 12, 'eenheid' => 'set', 'kostprijs' => 9.50, 'verkoopprijs' => 19.95],
            ['naam' => 'Heat Protect Spray', 'sku' => 'PRD-005', 'beschrijving' => 'Bescherming bij styling', 'voorraad_aantal' => 30, 'eenheid' => 'fles', 'kostprijs' => 4.10, 'verkoopprijs' => 10.95],
        ];

        foreach ($producten as $product) {
            DB::table('producten')->updateOrInsert(
                ['sku' => $product['sku']],
                array_merge($product, ['actief' => true, 'created_at' => $now, 'updated_at' => $now]),
            );
        }

        $behandelingen = [
            ['naam' => 'Knippen', 'type' => 'Haar', 'beschrijving' => 'Knippen en afwerken', 'duur_minuten' => 45, 'prijs' => 32.50],
            ['naam' => 'Kleuren', 'type' => 'Haar', 'beschrijving' => 'Volledige kleurbehandeling', 'duur_minuten' => 90, 'prijs' => 68.00],
            ['naam' => 'Styling', 'type' => 'Haar', 'beschrijving' => 'Stylen en fohnen', 'duur_minuten' => 40, 'prijs' => 29.95],
            ['naam' => 'Extensions', 'type' => 'Haar', 'beschrijving' => 'Extensions plaatsen', 'duur_minuten' => 120, 'prijs' => 110.00],
            ['naam' => 'Basic Gezichtsbehandeling', 'type' => 'Gezicht', 'beschrijving' => 'Basis gezichtsbehandeling', 'duur_minuten' => 45, 'prijs' => 45.00],
        ];

        foreach ($behandelingen as $behandeling) {
            DB::table('behandelingen')->updateOrInsert(
                ['naam' => $behandeling['naam'], 'type' => $behandeling['type']],
                array_merge($behandeling, ['actief' => true, 'created_at' => $now, 'updated_at' => $now]),
            );
        }

        $medewerkerIds = DB::table('medewerkers')->pluck('id', 'personeelsnummer');
        $klantIds = DB::table('klanten')->join('gebruikers', 'klanten.gebruiker_id', '=', 'gebruikers.id')->pluck('klanten.id', 'gebruikers.email');
        $productIds = DB::table('producten')->pluck('id', 'sku');
        $behandelingIds = DB::table('behandelingen')->pluck('id', 'naam');

        $this->syncPair('medewerker_behandeling', 'medewerker_id', 'behandeling_id', [
            [$medewerkerIds['MW-001'], $behandelingIds['Knippen']],
            [$medewerkerIds['MW-001'], $behandelingIds['Kleuren']],
            [$medewerkerIds['MW-002'], $behandelingIds['Knippen']],
            [$medewerkerIds['MW-003'], $behandelingIds['Kleuren']],
            [$medewerkerIds['MW-004'], $behandelingIds['Styling']],
            [$medewerkerIds['MW-005'], $behandelingIds['Extensions']],
        ]);

        foreach ([
            ['behandeling' => 'Knippen', 'sku' => 'PRD-001', 'hoeveelheid' => 1.00],
            ['behandeling' => 'Kleuren', 'sku' => 'PRD-002', 'hoeveelheid' => 1.50],
            ['behandeling' => 'Styling', 'sku' => 'PRD-003', 'hoeveelheid' => 1.00],
            ['behandeling' => 'Extensions', 'sku' => 'PRD-004', 'hoeveelheid' => 2.00],
            ['behandeling' => 'Basic Gezichtsbehandeling', 'sku' => 'PRD-005', 'hoeveelheid' => 1.00],
        ] as $item) {
            DB::table('behandeling_product')->updateOrInsert(
                ['behandeling_id' => $behandelingIds[$item['behandeling']], 'product_id' => $productIds[$item['sku']]],
                ['hoeveelheid' => $item['hoeveelheid'], 'created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            ['email' => 'tom@kniplokettiko.nl', 'type' => 'allergie', 'titel' => 'Parfum', 'beschrijving' => 'Klant reageert op sterk geparfumeerde producten'],
            ['email' => 'sanne@example.test', 'type' => 'voorkeur', 'titel' => 'Ochtend', 'beschrijving' => 'Boekt graag voor 11:00'],
            ['email' => 'nora@example.test', 'type' => 'wens', 'titel' => 'Rustige plek', 'beschrijving' => 'Wil rustige behandelplek'],
            ['email' => 'mila@example.test', 'type' => 'medisch', 'titel' => 'Gevoelige huid', 'beschrijving' => 'Voorzichtig met kleurproducten'],
            ['email' => 'daan@example.test', 'type' => 'voorkeur', 'titel' => 'Vaste stylist', 'beschrijving' => 'Boekt het liefst bij Emma'],
        ] as $kenmerk) {
            DB::table('klant_kenmerken')->updateOrInsert(
                ['klant_id' => $klantIds[$kenmerk['email']], 'type' => $kenmerk['type'], 'titel' => $kenmerk['titel']],
                ['beschrijving' => $kenmerk['beschrijving'], 'actief' => true, 'created_at' => $now, 'updated_at' => $now],
            );
        }

        $afspraken = [
            ['klant' => 'tom@kniplokettiko.nl', 'medewerker' => 'MW-001', 'start' => '2026-07-08 10:00:00', 'eind' => '2026-07-08 11:00:00', 'status' => 'gepland', 'opmerking' => 'Eerste afspraak', 'notitie' => 'Gebruik parfumvrije producten', 'prijs' => 32.50, 'aangemaakt_door' => 'sanne@example.test'],
            ['klant' => 'sanne@example.test', 'medewerker' => 'MW-002', 'start' => '2026-07-09 09:30:00', 'eind' => '2026-07-09 10:15:00', 'status' => 'bevestigd', 'opmerking' => 'Punten knippen', 'notitie' => null, 'prijs' => 32.50, 'aangemaakt_door' => 'nora@example.test'],
            ['klant' => 'nora@example.test', 'medewerker' => 'MW-003', 'start' => '2026-07-10 13:00:00', 'eind' => '2026-07-10 14:30:00', 'status' => 'gepland', 'opmerking' => 'Uitgroei bijwerken', 'notitie' => null, 'prijs' => 68.00, 'aangemaakt_door' => 'mila@example.test'],
            ['klant' => 'mila@example.test', 'medewerker' => 'MW-004', 'start' => '2026-07-11 15:00:00', 'eind' => '2026-07-11 15:45:00', 'status' => 'gepland', 'opmerking' => 'Styling voor feest', 'notitie' => null, 'prijs' => 29.95, 'aangemaakt_door' => 'daan@example.test'],
            ['klant' => 'daan@example.test', 'medewerker' => 'MW-005', 'start' => '2026-07-12 12:00:00', 'eind' => '2026-07-12 14:00:00', 'status' => 'gepland', 'opmerking' => 'Extensions intake', 'notitie' => null, 'prijs' => 110.00, 'aangemaakt_door' => 'yara@example.test'],
        ];

        foreach ($afspraken as $afspraak) {
            DB::table('afspraken')->updateOrInsert(
                ['klant_id' => $klantIds[$afspraak['klant']], 'start_datumtijd' => $afspraak['start']],
                [
                    'medewerker_id' => $medewerkerIds[$afspraak['medewerker']],
                    'eind_datumtijd' => $afspraak['eind'],
                    'status' => $afspraak['status'],
                    'opmerking_klant' => $afspraak['opmerking'],
                    'interne_notitie' => $afspraak['notitie'],
                    'totaalprijs' => $afspraak['prijs'],
                    'aangemaakt_door_gebruiker_id' => $gebruikerIds[$afspraak['aangemaakt_door']],
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }

        $afspraakIds = DB::table('afspraken')->pluck('id', 'start_datumtijd');

        foreach ([
            ['start' => '2026-07-08 10:00:00', 'behandeling' => 'Knippen', 'prijs' => 32.50, 'duur' => 45, 'notitie' => 'Knippen basis'],
            ['start' => '2026-07-09 09:30:00', 'behandeling' => 'Knippen', 'prijs' => 32.50, 'duur' => 45, 'notitie' => 'Punten knippen'],
            ['start' => '2026-07-10 13:00:00', 'behandeling' => 'Kleuren', 'prijs' => 68.00, 'duur' => 90, 'notitie' => 'Uitgroei bijwerken'],
            ['start' => '2026-07-11 15:00:00', 'behandeling' => 'Styling', 'prijs' => 29.95, 'duur' => 40, 'notitie' => 'Styling feest'],
            ['start' => '2026-07-12 12:00:00', 'behandeling' => 'Extensions', 'prijs' => 110.00, 'duur' => 120, 'notitie' => 'Extensions intake'],
        ] as $item) {
            DB::table('afspraak_behandeling')->updateOrInsert(
                ['afspraak_id' => $afspraakIds[$item['start']], 'behandeling_id' => $behandelingIds[$item['behandeling']]],
                [
                    'prijs_op_moment' => $item['prijs'],
                    'duur_minuten_op_moment' => $item['duur'],
                    'notitie' => $item['notitie'],
                    'uitgevoerd' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            );
        }
    }

    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        DB::table('afspraak_behandeling')->delete();
        DB::table('afspraken')->whereIn('start_datumtijd', [
            '2026-07-08 10:00:00',
            '2026-07-09 09:30:00',
            '2026-07-10 13:00:00',
            '2026-07-11 15:00:00',
            '2026-07-12 12:00:00',
        ])->delete();
        DB::table('klant_kenmerken')->delete();
        DB::table('behandeling_product')->delete();
        DB::table('medewerker_behandeling')->delete();
        DB::table('behandelingen')->whereIn('naam', ['Knippen', 'Kleuren', 'Styling', 'Extensions', 'Basic Gezichtsbehandeling'])->delete();
        DB::table('producten')->whereIn('sku', ['PRD-001', 'PRD-002', 'PRD-003', 'PRD-004', 'PRD-005'])->delete();
        DB::table('klanten')->delete();
        DB::table('medewerkers')->whereIn('personeelsnummer', ['MW-001', 'MW-002', 'MW-003', 'MW-004', 'MW-005'])->delete();
        DB::table('gebruikers')->whereIn('email', [
            'Eigenaar123!?@gmail.com',
            'lisa@kniplokettiko.nl',
            'laura@kniplokettiko.nl',
            'mark@kniplokettiko.nl',
            'emma@kniplokettiko.nl',
            'tom@kniplokettiko.nl',
            'sanne@example.test',
            'nora@example.test',
            'mila@example.test',
            'daan@example.test',
            'yara@example.test',
        ])->delete();
        DB::table('rollen')->whereIn('naam', ['eigenaar', 'medewerker', 'klant', 'planner', 'beheerder'])->delete();
    }

    private function syncPair(string $table, string $firstColumn, string $secondColumn, array $pairs): void
    {
        foreach ($pairs as [$firstId, $secondId]) {
            DB::table($table)->updateOrInsert(
                [$firstColumn => $firstId, $secondColumn => $secondId],
            );
        }
    }
};
