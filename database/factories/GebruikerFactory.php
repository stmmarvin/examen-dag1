<?php

namespace Database\Factories;

use App\Models\Gebruiker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gebruiker>
 */
class GebruikerFactory extends Factory
{
    protected $model = Gebruiker::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rol_id' => 1,
            'voornaam' => fake()->firstName(),
            'achternaam' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'telefoon' => fake()->phoneNumber(),
            'wachtwoord' => Hash::make('password'),
            'actief' => true,
            'laatste_login' => null,
        ];
    }

    /**
     * Indicate that the gebruiker is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'actief' => false,
        ]);
    }
}
