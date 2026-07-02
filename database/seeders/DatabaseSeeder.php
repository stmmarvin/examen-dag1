<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Treatment;
use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'rolename' => 'admin',
        ]);

        // Create clients
        $clients = [
            [
                'first_name' => 'Sophie',
                'last_name' => 'de Vries',
                'phone' => '06 12 34 56 78',
                'email' => 'sophie@example.com',
            ],
            [
                'first_name' => 'Emma',
                'last_name' => 'Jansen',
                'phone' => '06 23 45 67 89',
                'email' => 'emma@example.com',
            ],
            [
                'first_name' => 'Laura',
                'last_name' => 'Bakker',
                'phone' => '06 34 56 78 90',
                'email' => 'laura@example.com',
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Meijer',
                'phone' => '06 45 67 89 01',
                'email' => 'anna@example.com',
            ],
            [
                'first_name' => 'Julia',
                'last_name' => 'Peters',
                'phone' => '06 56 78 90 12',
                'email' => 'julia@example.com',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }

        // Create employees
        $employees = [
            [
                'name' => 'Lisa',
                'specialty' => 'Hairstylist',
                'phone' => '06 11 22 33 44',
                'email' => 'lisa@kapsalon.nl',
            ],
            [
                'name' => 'Mark',
                'specialty' => 'Barber',
                'phone' => '06 22 33 44 55',
                'email' => 'mark@kapsalon.nl',
            ],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }

        // Create treatments
        $treatments = [
            [
                'name' => 'Knippen & Föhnen',
                'description' => 'Lang haar',
                'duration_minutes' => 60,
                'price' => 45.00,
            ],
            [
                'name' => 'Knippen',
                'description' => 'Kort haar',
                'duration_minutes' => 30,
                'price' => 28.00,
            ],
            [
                'name' => 'Balayage',
                'description' => 'Lang haar',
                'duration_minutes' => 120,
                'price' => 95.00,
            ],
            [
                'name' => 'Highlights',
                'description' => 'Halflang haar',
                'duration_minutes' => 90,
                'price' => 75.00,
            ],
            [
                'name' => 'Föhnen',
                'description' => 'Lang haar',
                'duration_minutes' => 45,
                'price' => 32.00,
            ],
            [
                'name' => 'Face Framing',
                'description' => '',
                'duration_minutes' => 60,
                'price' => 55.00,
            ],
        ];

        foreach ($treatments as $treatment) {
            Treatment::create($treatment);
        }

        // Create appointments
        $appointments = [
            [
                'client_id' => 1,
                'employee_id' => 1,
                'treatment_id' => 1,
                'appointment_date' => '2024-05-12 09:00:00',
                'duration_minutes' => 60,
                'status' => 'bevestigd',
                'notes' => 'Licht blond',
            ],
            [
                'client_id' => 2,
                'employee_id' => 2,
                'treatment_id' => 2,
                'appointment_date' => '2024-05-12 11:00:00',
                'duration_minutes' => 30,
                'status' => 'bevestigd',
                'notes' => '',
            ],
            [
                'client_id' => 3,
                'employee_id' => 1,
                'treatment_id' => 2,
                'appointment_date' => '2024-05-13 14:00:00',
                'duration_minutes' => 30,
                'status' => 'in afwachting',
                'notes' => 'Kort haar',
            ],
            [
                'client_id' => 4,
                'employee_id' => 2,
                'treatment_id' => 4,
                'appointment_date' => '2024-05-14 10:30:00',
                'duration_minutes' => 90,
                'status' => 'bevestigd',
                'notes' => 'Face framing',
            ],
            [
                'client_id' => 5,
                'employee_id' => 1,
                'treatment_id' => 5,
                'appointment_date' => '2024-05-15 13:00:00',
                'duration_minutes' => 45,
                'status' => 'geannuleerd',
                'notes' => 'Ziek',
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
