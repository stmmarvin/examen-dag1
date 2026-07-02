<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KlantKenmerk extends Model
{
    use HasFactory;

    protected $table = 'klant_kenmerken';

    protected $fillable = [
        'klant_id',
        'type',
        'titel',
        'beschrijving',
        'actief',
    ];

    protected $casts = [
        'actief' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the klant that owns the kenmerk.
     */
    public function klant(): BelongsTo
    {
        return $this->belongsTo(Klant::class, 'klant_id');
    }
}
