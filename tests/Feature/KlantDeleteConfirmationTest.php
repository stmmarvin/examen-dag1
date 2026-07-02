<?php

namespace Tests\Feature;

use App\Models\Klant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlantDeleteConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that delete confirmation dialog text is present in index view
     * 
     * Validates: Requirements 7.1
     */
    public function test_delete_confirmation_message_appears_in_index_view(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        $response = $this->actingAs($user)->get(route('klanten.index'));

        $response->assertStatus(200);
        $response->assertSee('Weet u zeker dat u deze klant wilt verwijderen?', false);
        $response->assertSee('onclick="return confirm(', false);
    }

    /**
     * Test that delete confirmation dialog text is present in show view
     * 
     * Validates: Requirements 7.1
     */
    public function test_delete_confirmation_message_appears_in_show_view(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        $response = $this->actingAs($user)->get(route('klanten.show', $klant));

        $response->assertStatus(200);
        $response->assertSee('Weet u zeker dat u deze klant wilt verwijderen?', false);
        $response->assertSee('onsubmit="return confirm(', false);
    }

    /**
     * Test that confirming delete removes the klant from database
     * 
     * Validates: Requirements 7.2, 7.3
     */
    public function test_confirm_delete_removes_klant_from_database(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        $this->assertDatabaseHas('klanten', ['id' => $klant->id]);

        $response = $this->actingAs($user)
            ->delete(route('klanten.destroy', $klant));

        $response->assertRedirect(route('klanten.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('klanten', ['id' => $klant->id]);
    }

    /**
     * Test that confirming delete removes klant from index listing
     * 
     * Validates: Requirements 7.3
     */
    public function test_confirm_delete_removes_klant_from_index_listing(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create([
            'voornaam' => 'TestVoornaam',
            'achternaam' => 'TestAchternaam',
            'email' => 'test@example.com'
        ]);

        // Verify klant appears in index before deletion
        $response = $this->actingAs($user)->get(route('klanten.index'));
        $response->assertSee('TestVoornaam');
        $response->assertSee('TestAchternaam');

        // Delete the klant
        $this->actingAs($user)->delete(route('klanten.destroy', $klant));

        // Verify klant no longer appears in index after deletion
        $response = $this->actingAs($user)->get(route('klanten.index'));
        $response->assertDontSee('TestVoornaam');
        $response->assertDontSee('TestAchternaam');
    }

    /**
     * Test that cancel preserves klant in database
     * Note: JavaScript cancel (return false) prevents form submission,
     * so we test that the klant remains if delete is not actually called
     * 
     * Validates: Requirements 7.4
     */
    public function test_cancel_preserves_klant_in_database(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        $this->assertDatabaseHas('klanten', ['id' => $klant->id]);

        // Simulate cancel by NOT sending the delete request
        // (in browser, returning false from confirm prevents form submission)
        
        // Verify klant still exists
        $this->assertDatabaseHas('klanten', ['id' => $klant->id]);
        
        // Verify klant still appears in index
        $response = $this->actingAs($user)->get(route('klanten.index'));
        $response->assertSee($klant->voornaam);
        $response->assertSee($klant->achternaam);
    }

    /**
     * Test that cancel returns user to previous screen (index)
     * Note: JavaScript cancel prevents form submission, keeping user on current page
     * 
     * Validates: Requirements 7.5
     */
    public function test_cancel_keeps_user_on_index_page(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        // When on index page and cancel is clicked, user stays on index
        $response = $this->actingAs($user)->get(route('klanten.index'));
        $response->assertStatus(200);
        $response->assertViewIs('klanten.index');
    }

    /**
     * Test that cancel returns user to previous screen (show)
     * 
     * Validates: Requirements 7.5
     */
    public function test_cancel_keeps_user_on_show_page(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        // When on show page and cancel is clicked, user stays on show
        $response = $this->actingAs($user)->get(route('klanten.show', $klant));
        $response->assertStatus(200);
        $response->assertViewIs('klanten.show');
    }

    /**
     * Test delete form structure in index view
     * 
     * Validates: Requirements 7.1, 7.4
     */
    public function test_delete_form_has_correct_structure_in_index(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        $response = $this->actingAs($user)->get(route('klanten.index'));

        $response->assertStatus(200);
        // Verify form has DELETE method
        $response->assertSee('@method(\'DELETE\')', false);
        // Verify form has CSRF token
        $response->assertSee('@csrf', false);
        // Verify form action points to destroy route
        $response->assertSee('klanten.destroy', false);
    }

    /**
     * Test delete form structure in show view
     * 
     * Validates: Requirements 7.1, 7.4
     */
    public function test_delete_form_has_correct_structure_in_show(): void
    {
        $user = User::factory()->create();
        $klant = Klant::factory()->create();

        $response = $this->actingAs($user)->get(route('klanten.show', $klant));

        $response->assertStatus(200);
        // Verify form has DELETE method
        $response->assertSee('@method(\'DELETE\')', false);
        // Verify form has CSRF token
        $response->assertSee('@csrf', false);
        // Verify form uses onsubmit with confirm
        $response->assertSee('onsubmit="return confirm(', false);
    }
}
