<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medewerker extends Model
{
    protected $fillable = [
        'gebruiker_id',
        'personeelsnummer',
        'functie',
        'in_dienst_sinds',
        'werkdagen',
        'werktijden',
        'notities',
    ];

    protected function casts(): array
    {
        return [
            'in_dienst_sinds' => 'date',
        ];
    }

    /**
     * De medewerkergegevens horen bij de gebruiker uit het team-schema.
     */
    public function gebruiker(): BelongsTo
    {
        return $this->belongsTo(Gebruiker::class);
    }

    /**
     * Afspraken bepalen of verwijderen volgens de acceptatiecriteria mag.
     */
    public function afspraken(): HasMany
    {
        return $this->hasMany(Afspraak::class);
    }

    /**
     * Specialisaties worden opgeslagen als gekoppelde behandelingen.
     */
    public function behandelingen(): BelongsToMany
    {
        return $this->belongsToMany(Behandeling::class, 'medewerker_behandeling');
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
                ->orWhereHas('gebruiker', function (Builder $persoonQuery) use ($zoekterm): void {
                    $persoonQuery->where('voornaam', 'like', "%{$zoekterm}%")
                        ->orWhere('achternaam', 'like', "%{$zoekterm}%")
                        ->orWhere('telefoon', 'like', "%{$zoekterm}%")
                        ->orWhere('email', 'like', "%{$zoekterm}%");
                });
        });
    }

    /**
     * Controleer of deze medewerker nog ingepland staat na vandaag.
     */
    public function hasFutureAppointments(): bool
    {
        return $this->afspraken()
            ->where('start_datumtijd', '>=', now())
            ->where('status', '!=', 'geannuleerd')
            ->exists();
    }

    /**
     * Status wordt afgeleid uit de gekoppelde gebruiker.
     */
    public function statusTekst(): string
    {
        return $this->gebruiker?->actief ? 'In dienst' : 'Uit dienst';
    }

    /**
     * Maak specialisaties leesbaar voor detailkaarten en lijsten.
     */
    public function specialisatiesTekst(): string
    {
        return $this->behandelingen->pluck('naam')->implode(', ');
    }
}
