<?php

namespace Tests\Feature;

use App\Models\Gebruiker;
use App\Models\Klant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlantDeleteConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that delete confirmation message appears in index view
     * 
     * Validates: Requirements 7.1
     */
    public function test_delete_confirmation_message_appears_in_index_view(): void
    {
        $user = User::factory()->create();
        
        // Create gebruiker and klant
        $gebruiker = Gebruiker::create([
            'rol_id' => 2,
            'voornaam' => 'Test',
            'achternaam' => 'User',
            'email' => 'test@example.com',
            'telefoon' => '0612345678',
            'wachtwoord' => 'password',
            'actief' => true,
        ]);
        
        $klant = Klant::create([
            'gebruiker_id' => $gebruiker->id,
            'geboortedatum' => '1990-01-01',
        ]);

        $response = $this->actingAs($user)->get(route('klanten.index'));

        $response->assertStatus(200);
        // Check for the exact confirmation message in the HTML
        $response->assertSee('Weet u zeker dat u deze klant wilt verwijderen?', false);
    }

    /**
     * Test that delete confirmation message appears in show view
     * 
     * Validates: Requirements 7.1
     */
    public function test_delete_confirmation_message_appears_in_show_view(): void
    {
        $user = User::factory()->create();
        
        // Create gebruiker and klant
        $gebruiker = Gebruiker::create([
            'rol_id' => 2,
            'voornaam' => 'Test',
            'achternaam' => 'User',
            'email' => 'test@example.com',
            'telefoon' => '0612345678',
            'wachtwoord' => 'password',
            'actief' => true,
        ]);
        
        $klant = Klant::create([
            'gebruiker_id' => $gebruiker->id,
            'geboortedatum' => '1990-01-01',
        ]);

        $response = $this->actingAs($user)->get(route('klanten.show', $klant));

        $response->assertStatus(200);
        // Check for the exact confirmation message in the HTML
        $response->assertSee('Weet u zeker dat u deze klant wilt verwijderen?', false);
    }

    /**
     * Test that confirming delete removes the klant from database
     * 
     * Validates: Requirements 7.2, 7.3
     */
    public function test_confirm_delete_removes_klant_from_database(): void
    {
        $user = User::factory()->create();
        
        // Create gebruiker and klant
        $gebruiker = Gebruiker::create([
            'rol_id' => 2,
            'voornaam' => 'DeleteTest',
            'achternaam' => 'User',
            'email' => 'delete@example.com',
            'telefoon' => '0612345678',
            'wachtwoord' => 'password',
            'actief' => true,
        ]);
        
        $klant = Klant::create([
            'gebruiker_id' => $gebruiker->id,
            'geboortedatum' => '1990-01-01',
        ]);

        $this->assertDatabaseHas('klanten', ['id' => $klant->id]);

        $response = $this->actingAs($user)
            ->delete(route('klanten.destroy', $klant));

        $response->assertRedirect(route('klanten.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('klanten', ['id' => $klant->id]);
    }

    /**
     * Test that delete button uses JavaScript confirm in index
     * 
     * Validates: Requirements 7.1, 7.4, 7.5
     */
    public function test_delete_button_has_onclick_confirm_in_index(): void
    {
        $user = User::factory()->create();
        
        // Create gebruiker and klant
        $gebruiker = Gebruiker::create([
            'rol_id' => 2,
            'voornaam' => 'Test',
            'achternaam' => 'User',
            'email' => 'test@example.com',
            'telefoon' => '0612345678',
            'wachtwoord' => 'password',
            'actief' => true,
        ]);
        
        $klant = Klant::create([
            'gebruiker_id' => $gebruiker->id,
            'geboortedatum' => '1990-01-01',
        ]);

        $response = $this->actingAs($user)->get(route('klanten.index'));

        $response->assertStatus(200);
        // Verify the onclick attribute with return confirm() is present
        $response->assertSee('onclick="return confirm(', false);
    }

    /**
     * Test that delete form uses JavaScript confirm in show
     * 
     * Validates: Requirements 7.1, 7.4, 7.5
     */
    public function test_delete_form_has_onsubmit_confirm_in_show(): void
    {
        $user = User::factory()->create();
        
        // Create gebruiker and klant
        $gebruiker = Gebruiker::create([
            'rol_id' => 2,
            'voornaam' => 'Test',
            'achternaam' => 'User',
            'email' => 'test@example.com',
            'telefoon' => '0612345678',
            'wachtwoord' => 'password',
            'actief' => true,
        ]);
        
        $klant = Klant::create([
            'gebruiker_id' => $gebruiker->id,
            'geboortedatum' => '1990-01-01',
        ]);

        $response = $this->actingAs($user)->get(route('klanten.show', $klant));

        $response->assertStatus(200);
        // Verify the onsubmit attribute with return confirm() is present
        $response->assertSee('onsubmit="return confirm(', false);
    }
}
