<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_register_with_valid_data(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'telefoon' => '0612345678',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('profiel.index'));
        
        $this->assertDatabaseHas('users', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'telefoon' => '0612345678',
        ]);
    }

    /** @test */
    public function registration_requires_voornaam(): void
    {
        $response = $this->post('/register', [
            'voornaam' => '',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('voornaam');
        $this->assertGuest();
    }

    /** @test */
    public function registration_requires_achternaam(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => '',
            'email' => 'jan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('achternaam');
        $this->assertGuest();
    }

    /** @test */
    public function registration_requires_valid_email(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'invalid-email',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function registration_requires_unique_email(): void
    {
        User::factory()->create(['email' => 'jan@example.com']);

        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function registration_validates_phone_format(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'telefoon' => 'invalid-phone',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('telefoon');
        $this->assertGuest();
    }

    /** @test */
    public function registration_accepts_valid_dutch_phone(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'telefoon' => '0612345678',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'telefoon' => '0612345678',
        ]);
    }

    /** @test */
    public function registration_validates_name_contains_only_letters(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan123',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('voornaam');
        $this->assertGuest();
    }

    /** @test */
    public function registration_requires_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'voornaam' => 'Jan',
            'achternaam' => 'Jansen',
            'email' => 'jan@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}
