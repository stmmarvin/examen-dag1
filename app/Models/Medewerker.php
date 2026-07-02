<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medewerker extends Model
{
    protected $fillable = [
        'persoon_id',
        'functie',
        'specialisaties',
        'status',
        'startdatum',
        'werkdagen',
        'werktijden',
    ];

    protected function casts(): array
    {
        return [
            'specialisaties' => 'array',
            'startdatum' => 'date',
        ];
    }

    /**
     * De medewerkergegevens horen bij de persoonsgegevens.
     */
    public function persoon(): BelongsTo
    {
        return $this->belongsTo(Persoon::class);
    }

    /**
     * Afspraken bepalen of verwijderen volgens de acceptatiecriteria mag.
     */
    public function afspraken(): HasMany
    {
        return $this->hasMany(Afspraak::class);
    }

    /**
     * Scope voor de zoekbalk uit het overzicht-wireframe.
     */
    public function scopeZoeken(Builder $query, ?string $zoekterm): Builder
    {
        if (! $zoekterm) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($zoekterm): void {
            $query->where('functie', 'like', "%{$zoekterm}%")
                ->orWhere('status', 'like', "%{$zoekterm}%")
                ->orWhereHas('persoon', function (Builder $persoonQuery) use ($zoekterm): void {
                    $persoonQuery->where('voornaam', 'like', "%{$zoekterm}%")
                        ->orWhere('achternaam', 'like', "%{$zoekterm}%")
                        ->orWhere('telefoonnummer', 'like', "%{$zoekterm}%")
                        ->orWhere('emailadres', 'like', "%{$zoekterm}%");
                });
        });
    }

    /**
     * Controleer of deze medewerker nog ingepland staat na vandaag.
     */
    public function hasFutureAppointments(): bool
    {
        return $this->afspraken()
            ->where('starttijd', '>=', now())
            ->where('status', '!=', 'Geannuleerd')
            ->exists();
    }

    /**
     * Maak specialisaties leesbaar voor detailkaarten en lijsten.
     */
    public function specialisatiesTekst(): string
    {
        return implode(', ', $this->specialisaties ?? []);
    }
}
