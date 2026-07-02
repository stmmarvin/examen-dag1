<?php

namespace App\Models\Behandelingen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Behandeling extends Model
{
    use HasFactory;

    protected $table = 'behandelingen';

    protected $fillable = [
        'naam',
        'type',
        'duur_minuten',
        'prijs',
        'beschrijving',
        'aanvullende_informatie',
        'actief',
    ];

    protected function casts(): array
    {
        return [
            'duur_minuten' => 'integer',
            'prijs' => 'decimal:2',
            'actief' => 'boolean',
        ];
    }
}
