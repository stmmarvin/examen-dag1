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
                'aanvullende_informatie' => 'Geschikt voor kort tot halflang haar.',
            ],
            [
                'naam' => 'Dames knippen',
                'type' => 'Knippen',
                'duur_minuten' => 45,
                'prijs' => '32.50',
                'beschrijving' => 'Wassen, knippen en föhnen voor dames.',
                'aanvullende_informatie' => 'Prijs kan verschillen bij extra lang haar.',
            ],
            [
                'naam' => 'Kind knippen',
                'type' => 'Knippen',
                'duur_minuten' => 25,
                'prijs' => '17.50',
                'beschrijving' => 'Knipbehandeling voor kinderen tot en met 12 jaar.',
                'aanvullende_informatie' => 'Ouder/verzorger mag erbij blijven.',
            ],
            [
                'naam' => 'Baard trimmen',
                'type' => 'Baard',
                'duur_minuten' => 20,
                'prijs' => '15.00',
                'beschrijving' => 'Baard in model trimmen en netjes afwerken.',
                'aanvullende_informatie' => 'Inclusief contouren bijwerken.',
            ],
            [
                'naam' => 'Uitgroei kleuren',
                'type' => 'Kleuren',
                'duur_minuten' => 75,
                'prijs' => '49.50',
                'beschrijving' => 'Kleuren van de uitgroei inclusief korte nabewerking.',
                'aanvullende_informatie' => 'Vooraf allergie of kleurwens controleren.',
            ],
            [
                'naam' => 'Highlights',
                'type' => 'Kleuren',
                'duur_minuten' => 120,
                'prijs' => '89.00',
                'beschrijving' => 'Highlights zetten voor een lichtere uitstraling.',
                'aanvullende_informatie' => 'Eindtijd hangt af van haarlengte en gewenste dekking.',
            ],
            [
                'naam' => 'Wassen en föhnen',
                'type' => 'Styling',
                'duur_minuten' => 30,
                'prijs' => '24.50',
                'beschrijving' => 'Haar wassen en in model föhnen.',
                'aanvullende_informatie' => 'Kan gecombineerd worden met andere behandelingen.',
            ],
            [
                'naam' => 'Bruidskapsel proef',
                'type' => 'Styling',
                'duur_minuten' => 90,
                'prijs' => '75.00',
                'beschrijving' => 'Proefsessie voor een bruidskapsel.',
                'aanvullende_informatie' => 'Neem voorbeelden of inspiratie mee naar de afspraak.',
            ],
        ];
    }
}
