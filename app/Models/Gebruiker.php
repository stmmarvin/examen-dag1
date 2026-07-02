<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gebruiker extends Model
{
    protected $table = 'gebruikers';

    protected $fillable = [
        'rol_id',
        'voornaam',
        'achternaam',
        'email',
        'telefoon',
        'wachtwoord',
        'actief',
        'laatste_login',
    ];

    protected function casts(): array
    {
        return [
            'actief' => 'boolean',
            'laatste_login' => 'datetime',
        ];
    }

    /**
     * In het schema is een medewerker een uitbreiding op een gebruiker.
     */
    public function medewerker(): HasOne
    {
        return $this->hasOne(Medewerker::class);
    }

    /**
     * Naamweergave zoals in het medewerker-overzicht.
     */
    public function getVolledigeNaamAttribute(): string
    {
        return trim($this->voornaam.' '.$this->achternaam);
    }
}
