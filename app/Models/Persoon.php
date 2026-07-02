<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persoon extends Model
{
    protected $table = 'personen';

    protected $fillable = [
        'voornaam',
        'achternaam',
        'telefoonnummer',
        'emailadres',
    ];

    /**
     * Een persoon kan in deze casus precies een medewerkerprofiel hebben.
     */
    public function medewerker(): HasOne
    {
        return $this->hasOne(Medewerker::class);
    }

    /**
     * Geef de naam terug zoals die in de wireframes staat.
     */
    public function getVolledigeNaamAttribute(): string
    {
        return trim($this->voornaam.' '.$this->achternaam);
    }
}
