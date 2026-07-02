<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Behandeling extends Model
{
    protected $fillable = [
        'naam',
        'type',
        'beschrijving',
        'duur_minuten',
        'prijs',
        'actief',
    ];

    protected function casts(): array
    {
        return [
            'actief' => 'boolean',
            'prijs' => 'decimal:2',
        ];
    }

    /**
     * Behandelingen vormen de specialisaties van een medewerker.
     */
    public function medewerkers(): BelongsToMany
    {
        return $this->belongsToMany(Medewerker::class, 'medewerker_behandeling');
    }
}
