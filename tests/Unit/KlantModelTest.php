<?php

namespace Tests\Unit;

use App\Models\Gebruiker;
use App\Models\Klant;
use App\Models\KlantKenmerk;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlantModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_fillable_fields()
    {
        $fillable = [
            'gebruiker_id',
            'geboortedatum',
            'adresregel1',
            'adresregel2',
            'postcode',
            'plaats',
            'land',
            'algemene_notities',
        ];

        $klant = new Klant();
        
        $this->assertEquals($fillable, $klant->getFillable());
    }

    public function test_it_casts_geboortedatum_as_date()
    {
        $klant = new Klant();
        $casts = $klant->getCasts();
        
        $this->assertEquals('date', $casts['geboortedatum']);
    }

    public function test_it_uses_klanten_table()
    {
        $klant = new Klant();
        
        $this->assertEquals('klanten', $klant->getTable());
    }

    public function test_it_has_gebruiker_relationship()
    {
        $klant = new Klant();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $klant->gebruiker()
        );
    }

    public function test_it_has_klant_kenmerken_relationship()
    {
        $klant = new Klant();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $klant->klantKenmerken()
        );
    }
}
