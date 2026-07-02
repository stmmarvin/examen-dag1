<?php

namespace Tests\Feature;

use App\Models\Gebruiker;
use App\Models\Klant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test 404 handling for non-existent klanten
 * 
 * Requirements: 8.1, 8.2, 8.3
 */
class KlantNotFoundTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that accessing non-existent klant on show page returns 404
     * 
     * Requirements: 8.1, 8.2, 8.3
     */
    public function test_show_non_existent_klant_returns_404(): void
    {
        $user = User::factory()->create();
        
        // Try to access a klant that doesn't exist (ID 999)
        $response = $this->actingAs($user)->get('/klanten/999');
        
        // Laravel's route model binding should return 404
        $response->assertStatus(404);
    }

    /**
     * Test that accessing non-existent klant on edit page returns 404
     * 
     * Requirements: 8.1, 8.2, 8.3
     */
    public function test_edit_non_existent_klant_returns_404(): void
    {
        $user = User::factory()->create();
        
        // Try to access edit form for klant that doesn't exist
        $response = $this->actingAs($user)->get('/klanten/999/edit');
        
        // Laravel's route model binding should return 404
        $response->assertStatus(404);
    }

    /**
     * Test that updating non-existent klant returns 404
     * 
     * Requirements: 8.1, 8.2, 8.3
     */
    public function test_update_non_existent_klant_returns_404(): void
    {
        $user = User::factory()->create();
        
        // Try to update a klant that doesn't exist
        $response = $this->actingAs($user)->put('/klanten/999', [
            'voornaam' => 'Test',
            'achternaam' => 'User',
            'email' => 'test@example.com',
            'telefoon' => '0612345678',
        ]);
        
        // Laravel's route model binding should return 404
        $response->assertStatus(404);
    }

    /**
     * Test that deleting non-existent klant returns 404
     * 
     * Requirements: 8.1, 8.2, 8.3
     */
    public function test_delete_non_existent_klant_returns_404(): void
    {
        $user = User::factory()->create();
        
        // Try to delete a klant that doesn't exist
        $response = $this->actingAs($user)->delete('/klanten/999');
        
        // Laravel's route model binding should return 404
        $response->assertStatus(404);
    }

    /**
     * Test that route model binding works correctly for existing klant
     * 
     * This verifies the positive case - that valid klanten can be accessed
     */
    public function test_accessing_existing_klant_works(): void
    {
        $user = User::factory()->create();
        
        // Create a gebruiker with rol_id=2 (klant role)
        $gebruiker = Gebruiker::create([
            'rol_id' => 2,
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'telefoon' => '0612345678',
            'wachtwoord' => 'not-used',
            'actief' => true,
        ]);

        // Create a klant
        $klant = Klant::create([
            'gebruiker_id' => $gebruiker->id,
            'geboortedatum' => '1990-01-01',
            'adresregel1' => 'Teststraat 1',
            'postcode' => '1234AB',
            'plaats' => 'Amsterdam',
        ]);
        
        // Accessing existing klant should work (not 404)
        $response = $this->actingAs($user)->get("/klanten/{$klant->id}");
        
        // Should be successful (200 OK)
        $response->assertStatus(200);
    }
}
