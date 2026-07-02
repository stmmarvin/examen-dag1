<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EigenaarSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'Eigenaar123!?@gmail.com'],
            [
                'name' => 'Eigenaar',
                'email' => 'Eigenaar123!?@gmail.com',
                'password' => Hash::make('123eig'),
                'rolename' => 'eigenaar',
                'voornaam' => 'Eigenaar',
                'achternaam' => 'Kniploket',
            ]
        );
    }
}
