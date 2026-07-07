<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Behandeling extends Model
{
    protected $table = 'behandelingen';

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
     * Behandelingen zijn de specialisaties van medewerkers.
     */
    public function medewerkers(): BelongsToMany
    {
        return $this->belongsToMany(Medewerker::class, 'medewerker_behandeling');
    }
}
