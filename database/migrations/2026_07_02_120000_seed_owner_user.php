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

        DB::table('users')->updateOrInsert(
            ['email' => 'Eigenaar123!?@gmail.com'],
            [
                'name' => 'Eigenaar',
                'email' => 'Eigenaar123!?@gmail.com',
                'password' => Hash::make('123eig'),
                'rolename' => 'eigenaar',
                'email_verified_at' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    public function down(): void
    {
        if (app()->environment('testing')) {
            return;
        }

        DB::table('users')
            ->where('email', 'Eigenaar123!?@gmail.com')
            ->delete();
    }
};
