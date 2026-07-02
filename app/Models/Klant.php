<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Klant extends Model
{
    use HasFactory;

    protected $table = 'klanten';

    protected $fillable = [
        'gebruiker_id',
        'geboortedatum',
        'adresregel1',
        'adresregel2',
        'postcode',
        'plaats',
        'land',
        'algemene_notities',
    ];

    protected $casts = [
        'geboortedatum' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the gebruiker that owns the klant.
     */
    public function gebruiker(): BelongsTo
    {
        return $this->belongsTo(Gebruiker::class, 'gebruiker_id');
    }

    /**
     * Get the kenmerken for the klant.
     */
    public function klantKenmerken(): HasMany
    {
        return $this->hasMany(KlantKenmerk::class, 'klant_id');
    }

    /**
     * Accessor for volledige naam from gebruiker relation.
     */
    public function getVolledigeNaamAttribute(): string
    {
        return $this->gebruiker 
            ? "{$this->gebruiker->voornaam} {$this->gebruiker->achternaam}"
            : '';
    }

    /**
     * Accessor for voornaam from gebruiker relation.
     */
    public function getVoornaamAttribute(): ?string
    {
        return $this->gebruiker?->voornaam;
    }

    /**
     * Accessor for achternaam from gebruiker relation.
     */
    public function getAchternaamAttribute(): ?string
    {
        return $this->gebruiker?->achternaam;
    }

    /**
     * Accessor for email from gebruiker relation.
     */
    public function getEmailAttribute(): ?string
    {
        return $this->gebruiker?->email;
    }

    /**
     * Accessor for telefoon from gebruiker relation.
     */
    public function getTelefoonAttribute(): ?string
    {
        return $this->gebruiker?->telefoon;
    }

    /**
     * Get allergieen from klant_kenmerken relation.
     */
    public function getAllergieen()
    {
        return $this->klantKenmerken()
            ->where('type', 'allergie')
            ->where('actief', true)
            ->get();
    }

    /**
     * Get wensen from klant_kenmerken relation.
     */
    public function getWensen()
    {
        return $this->klantKenmerken()
            ->where('type', 'wens')
            ->where('actief', true)
            ->get();
    }
}
