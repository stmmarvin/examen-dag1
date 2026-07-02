<?php

namespace App\Models\Behandelingen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Behandeling extends Model
{
    use HasFactory;

    // Deze model hoort bij de tabel behandelingen.
    protected $table = 'behandelingen';

    // Velden die ingevuld mogen worden via het formulier.
    protected $fillable = [
        'naam',
        'type',
        'duur_minuten',
        'prijs',
        'beschrijving',
        'aanvullende_informatie',
        'actief',
    ];

    // Zet database waardes om naar de juiste types in PHP.
    protected function casts(): array
    {
        return [
            'duur_minuten' => 'integer',
            'prijs' => 'decimal:2',
            'actief' => 'boolean',
        ];
    }
}
