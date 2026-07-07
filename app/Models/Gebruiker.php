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
     * Een gebruiker kan in dit schema gekoppeld zijn aan een medewerker.
     */
    public function medewerker(): HasOne
    {
        return $this->hasOne(Medewerker::class);
    }

    /**
     * Naam zoals die in de wireframes getoond wordt.
     */
    public function getVolledigeNaamAttribute(): string
    {
        return trim($this->voornaam.' '.$this->achternaam);
    }
}
