<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            // Manager-account waarmee de beoordelaar direct de CRUD kan testen.
            'name' => 'Manager Kniploket Tiko',
            'email' => 'manager@kniplokettiko.nl',
            'rolename' => 'manager',
        ]);
    }
}
