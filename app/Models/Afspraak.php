<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Afspraak extends Model
{
    protected $table = 'afspraken';

    protected $fillable = [
        'klant_id',
        'medewerker_id',
        'start_datumtijd',
        'eind_datumtijd',
        'status',
        'opmerking_klant',
        'interne_notitie',
        'totaalprijs',
        'aangemaakt_door_gebruiker_id',
    ];

    protected function casts(): array
    {
        return [
            'start_datumtijd' => 'datetime',
            'eind_datumtijd' => 'datetime',
            'totaalprijs' => 'decimal:2',
        ];
    }

    /**
     * Elke afspraak is gekoppeld aan een medewerker uit de planning.
     */
    public function medewerker(): BelongsTo
    {
        return $this->belongsTo(Medewerker::class);
    }
}
