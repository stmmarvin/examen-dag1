<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfielTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_view_their_profile(): void
    {
        $user = User::factory()->create([
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
        ]);

        $response = $this->actingAs($user)->get('/profiel');

        $response->assertStatus(200);
        $response->assertSee('Jan');
        $response->assertSee('Jansen');
    }

    /** @test */
    public function guests_cannot_view_profile(): void
    {
        $response = $this->get('/profiel');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_users_can_update_their_profile(): void
    {
        $user = User::factory()->create([
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
        ]);

        $response = $this->actingAs($user)->patch('/profiel', [
            'voornaam' => 'Piet',
            'achternaam' => 'Pietersen',
            'email' => $user->email,
            'telefoon' => '0612345678',
            'adres' => 'Teststraat 123',
            'postcode' => '1234AB',
            'plaats' => 'Amsterdam',
        ]);

        $response->assertRedirect('/profiel');
        $response->assertSessionHas('success');

        $user->refresh();
        
        $this->assertEquals('Piet', $user->voornaam);
        $this->assertEquals('Pietersen', $user->achternaam);
        $this->assertEquals('0612345678', $user->telefoon);
        $this->assertEquals('1234AB', $user->postcode);
    }

    /** @test */
    public function profile_update_validates_postcode_format(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/profiel', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => $user->email,
            'postcode' => 'invalid',
        ]);

        $response->assertSessionHasErrors('postcode');
    }

    /** @test */
    public function profile_update_validates_phone_format(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/profiel', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => $user->email,
            'telefoon' => '123abc',
        ]);

        $response->assertSessionHasErrors('telefoon');
    }

    /** @test */
    public function profile_update_accepts_valid_dutch_postcode(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch('/profiel', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => $user->email,
            'postcode' => '1234AB',
        ]);

        $response->assertSessionHasNoErrors();
        $user->refresh();
        $this->assertEquals('1234AB', $user->postcode);
    }

    /** @test */
    public function authenticated_users_can_delete_their_account(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->delete('/profiel');

        $response->assertRedirect('/');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
