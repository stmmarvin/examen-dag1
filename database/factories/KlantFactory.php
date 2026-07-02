<?php

namespace Database\Factories;

use App\Models\Gebruiker;
use App\Models\Klant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Klant>
 */
class KlantFactory extends Factory
{
    protected $model = Klant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'gebruiker_id' => Gebruiker::factory(),
            'geboortedatum' => fake()->date('Y-m-d', '-18 years'),
            'adresregel1' => fake()->streetAddress(),
            'adresregel2' => null,
            'postcode' => fake()->postcode(),
            'plaats' => fake()->city(),
            'land' => 'Nederland',
            'algemene_notities' => fake()->optional()->paragraph(),
        ];
    }

    /**
     * State for minimal klant with only required fields.
     */
    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'geboortedatum' => null,
            'adresregel1' => null,
            'adresregel2' => null,
            'postcode' => null,
            'plaats' => null,
            'land' => null,
            'algemene_notities' => null,
        ]);
    }
}
