<?php

namespace App\Support\Behandelingen;

class BehandelingKeuzes
{
    public static function standaard(): array
    {
        // Standaard keuzes voor Kniploket Tiko.
        return [
            [
                'naam' => 'Heren knippen',
                'type' => 'Knippen',
                'duur_minuten' => 30,
                'prijs' => '22.50',
                'beschrijving' => 'Wassen, knippen en stylen voor heren.',
            ],
            [
                'naam' => 'Dames knippen',
                'type' => 'Knippen',
                'duur_minuten' => 45,
                'prijs' => '32.50',
                'beschrijving' => 'Wassen, knippen en fohnen voor dames.',
            ],
            [
                'naam' => 'Kind knippen',
                'type' => 'Knippen',
                'duur_minuten' => 25,
                'prijs' => '17.50',
                'beschrijving' => 'Knipbehandeling voor kinderen tot en met 12 jaar.',
            ],
            [
                'naam' => 'Baard trimmen',
                'type' => 'Baard',
                'duur_minuten' => 20,
                'prijs' => '15.00',
                'beschrijving' => 'Baard in model trimmen en netjes afwerken.',
            ],
            [
                'naam' => 'Uitgroei kleuren',
                'type' => 'Kleuren',
                'duur_minuten' => 75,
                'prijs' => '49.50',
                'beschrijving' => 'Kleuren van de uitgroei inclusief korte nabewerking.',
            ],
            [
                'naam' => 'Highlights',
                'type' => 'Kleuren',
                'duur_minuten' => 120,
                'prijs' => '89.00',
                'beschrijving' => 'Highlights zetten voor een lichtere uitstraling.',
            ],
            [
                'naam' => 'Wassen en fohnen',
                'type' => 'Styling',
                'duur_minuten' => 30,
                'prijs' => '24.50',
                'beschrijving' => 'Haar wassen en in model fohnen.',
            ],
            [
                'naam' => 'Bruidskapsel proef',
                'type' => 'Styling',
                'duur_minuten' => 90,
                'prijs' => '75.00',
                'beschrijving' => 'Proefsessie voor een bruidskapsel.',
            ],
        ];
    }
}
