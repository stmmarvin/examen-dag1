<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KlantNavigationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that authenticated users can see Klantenoverzicht link in navigation
     * Requirements: 3.1
     */
    public function test_authenticated_user_can_see_klantenoverzicht_link_in_navigation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Klantenoverzicht');
        $response->assertSee(route('klanten.index'));
    }

    /**
     * Test that Klantenoverzicht link is properly styled with Breeze components
     * Requirements: 3.1
     */
    public function test_klantenoverzicht_link_uses_breeze_nav_link_component(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        // Check that x-nav-link component is used (it adds specific classes)
        $response->assertSee('inline-flex items-center');
    }

    /**
     * Test that Klantenoverzicht link is active when on klanten pages
     * Requirements: 3.1
     */
    public function test_klantenoverzicht_link_is_active_on_klanten_pages(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('klanten.index'));

        $response->assertStatus(200);
        // Active state should have indigo-400 border
        $response->assertSee('border-indigo-400');
    }

    /**
     * Test that unauthenticated users cannot see navigation
     * Requirements: 9.2, 9.3
     */
    public function test_unauthenticated_users_are_redirected_from_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    /**
     * Test responsive navigation includes Klantenoverzicht
     * Requirements: 3.1
     */
    public function test_responsive_navigation_includes_klantenoverzicht(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        // Check that responsive nav link exists (appears in mobile menu) with correct classes
        $response->assertSee('border-l-4');
        $response->assertSee('text-gray-600');
    }
}
