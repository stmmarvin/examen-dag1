<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Afspraak extends Model
{
    protected $fillable = [
        'medewerker_id',
        'klantnaam',
        'behandeling',
        'starttijd',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'starttijd' => 'datetime',
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
