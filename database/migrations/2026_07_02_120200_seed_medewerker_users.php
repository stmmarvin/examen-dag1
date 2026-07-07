<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        $medewerkers = [
            ['name' => 'Lisa Jansen', 'voornaam' => 'Lisa', 'achternaam' => 'Jansen', 'email' => 'lisa@kniplokettiko.nl', 'telefoon' => '06 12345678'],
            ['name' => 'Laura Jansen', 'voornaam' => 'Laura', 'achternaam' => 'Jansen', 'email' => 'laura@kniplokettiko.nl', 'telefoon' => '06 23456789'],
            ['name' => 'Mark van Dijk', 'voornaam' => 'Mark', 'achternaam' => 'van Dijk', 'email' => 'mark@kniplokettiko.nl', 'telefoon' => '06 34567890'],
            ['name' => 'Emma Bakker', 'voornaam' => 'Emma', 'achternaam' => 'Bakker', 'email' => 'emma@kniplokettiko.nl', 'telefoon' => '06 45678901'],
            ['name' => 'Tom Meijer', 'voornaam' => 'Tom', 'achternaam' => 'Meijer', 'email' => 'tom@kniplokettiko.nl', 'telefoon' => '06 56789012'],
        ];

        foreach ($medewerkers as $medewerker) {
            DB::table('users')->updateOrInsert(
                ['email' => $medewerker['email']],
                [
                    'name' => $medewerker['name'],
                    'voornaam' => $medewerker['voornaam'],
                    'achternaam' => $medewerker['achternaam'],
                    'email' => $medewerker['email'],
                    'telefoon' => $medewerker['telefoon'],
                    'password' => Hash::make('Welkom123!'),
                    'rolename' => 'medewerker',
                    'email_verified_at' => null,
                    'remember_token' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        DB::table('users')->whereIn('email', [
            'lisa@kniplokettiko.nl',
            'laura@kniplokettiko.nl',
            'mark@kniplokettiko.nl',
            'emma@kniplokettiko.nl',
            'tom@kniplokettiko.nl',
        ])->delete();
    }
};
