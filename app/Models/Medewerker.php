<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medewerker extends Model
{
    protected $fillable = [
        'personeelsnummer',
        'voornaam',
        'achternaam',
        'telefoon',
        'email',
        'functie',
        'specialisaties',
        'status',
        'in_dienst_sinds',
        'werkdagen',
        'werktijden',
        'notities',
    ];

    protected function casts(): array
    {
        return [
            'specialisaties' => 'array',
            'in_dienst_sinds' => 'date',
        ];
    }

    /**
     * Afspraken bepalen alleen de verwijderblokkade uit de acceptatiecriteria.
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
                ->orWhere('personeelsnummer', 'like', "%{$zoekterm}%")
                ->orWhere('voornaam', 'like', "%{$zoekterm}%")
                ->orWhere('achternaam', 'like', "%{$zoekterm}%")
                ->orWhere('telefoon', 'like', "%{$zoekterm}%")
                ->orWhere('email', 'like', "%{$zoekterm}%");
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
     * Naamweergave zoals in de wireframes.
     */
    public function getVolledigeNaamAttribute(): string
    {
        return trim($this->voornaam.' '.$this->achternaam);
    }

    /**
     * Maak specialisaties leesbaar voor detailkaarten en lijsten.
     */
    public function specialisatiesTekst(): string
    {
        return implode(', ', $this->specialisaties ?? []);
    }
}
