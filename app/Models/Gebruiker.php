<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gebruiker extends Model
{
    use HasFactory;

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

    protected $casts = [
        'actief' => 'boolean',
        'laatste_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'wachtwoord',
    ];

    /**
     * Get the klant record associated with the gebruiker.
     */
    public function klant(): HasOne
    {
        return $this->hasOne(Klant::class, 'gebruiker_id');
    }
}
