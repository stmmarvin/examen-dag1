<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed de voorbeelddata voor de tabellen die door de Laravel-migraties
     * worden aangemaakt.
     */
    public function run(): void
    {
        $this->call(EigenaarSeeder::class);

        $treatments = [
            ['name' => 'Knippen', 'description' => 'Knippen en afwerken', 'duration_minutes' => 45, 'price' => 32.50],
            ['name' => 'Kleuren', 'description' => 'Volledige kleurbehandeling', 'duration_minutes' => 90, 'price' => 68.00],
            ['name' => 'Styling', 'description' => 'Stylen en fohnen', 'duration_minutes' => 40, 'price' => 29.95],
            ['name' => 'Extensions', 'description' => 'Extensions plaatsen', 'duration_minutes' => 120, 'price' => 110.00],
            ['name' => 'Basic Gezichtsbehandeling', 'description' => 'Basis gezichtsbehandeling', 'duration_minutes' => 45, 'price' => 45.00],
        ];

        foreach ($treatments as $treatment) {
            DB::table('treatments')->updateOrInsert(
                ['name' => $treatment['name']],
                [
                    'description' => $treatment['description'],
                    'duration_minutes' => $treatment['duration_minutes'],
                    'price' => $treatment['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }

        $employees = [
            ['name' => 'Lisa Jansen', 'phone' => '06 12345678', 'email' => 'lisa@kniplokettiko.nl', 'specialty' => 'Manager'],
            ['name' => 'Laura Jansen', 'phone' => '06 23456789', 'email' => 'laura@kniplokettiko.nl', 'specialty' => 'Kapster'],
            ['name' => 'Mark van Dijk', 'phone' => '06 34567890', 'email' => 'mark@kniplokettiko.nl', 'specialty' => 'Colorist'],
            ['name' => 'Emma Bakker', 'phone' => '06 45678901', 'email' => 'emma@kniplokettiko.nl', 'specialty' => 'Stylist'],
            ['name' => 'Tom Meijer', 'phone' => '06 56789012', 'email' => 'tom@kniplokettiko.nl', 'specialty' => 'Extensions specialist'],
        ];

        foreach ($employees as $employee) {
            DB::table('employees')->updateOrInsert(
                ['email' => $employee['email']],
                [
                    'name' => $employee['name'],
                    'phone' => $employee['phone'],
                    'specialty' => $employee['specialty'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }

        $clients = [
            ['first_name' => 'Sanne', 'last_name' => 'de Vries', 'phone' => '06 67890123', 'email' => 'sanne@example.test', 'notes' => 'Parfumvrij werken'],
            ['first_name' => 'Nora', 'last_name' => 'Peters', 'phone' => '06 78901234', 'email' => 'nora@example.test', 'notes' => 'Boekt graag voor 11:00'],
            ['first_name' => 'Mila', 'last_name' => 'Vos', 'phone' => '06 89012345', 'email' => 'mila@example.test', 'notes' => 'Studentenkorting'],
            ['first_name' => 'Daan', 'last_name' => 'Smit', 'phone' => '06 90123456', 'email' => 'daan@example.test', 'notes' => 'Gevoelige hoofdhuid'],
            ['first_name' => 'Yara', 'last_name' => 'Mulder', 'phone' => '06 01234567', 'email' => 'yara@example.test', 'notes' => 'Wil vaste stylist'],
        ];

        foreach ($clients as $client) {
            DB::table('clients')->updateOrInsert(
                ['email' => $client['email']],
                [
                    'first_name' => $client['first_name'],
                    'last_name' => $client['last_name'],
                    'phone' => $client['phone'],
                    'notes' => $client['notes'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }

        $treatmentIds = DB::table('treatments')->pluck('id', 'name');
        $employeeIds = DB::table('employees')->pluck('id', 'email');
        $clientIds = DB::table('clients')->pluck('id', 'email');

        $appointments = [
            ['client_email' => 'sanne@example.test', 'employee_email' => 'lisa@kniplokettiko.nl', 'treatment' => 'Knippen', 'appointment_date' => '2026-07-08 10:00:00', 'duration_minutes' => 45, 'status' => 'bevestigd', 'notes' => 'Eerste afspraak'],
            ['client_email' => 'nora@example.test', 'employee_email' => 'laura@kniplokettiko.nl', 'treatment' => 'Knippen', 'appointment_date' => '2026-07-09 09:30:00', 'duration_minutes' => 45, 'status' => 'bevestigd', 'notes' => 'Punten knippen'],
            ['client_email' => 'mila@example.test', 'employee_email' => 'mark@kniplokettiko.nl', 'treatment' => 'Kleuren', 'appointment_date' => '2026-07-10 13:00:00', 'duration_minutes' => 90, 'status' => 'in afwachting', 'notes' => 'Uitgroei bijwerken'],
            ['client_email' => 'daan@example.test', 'employee_email' => 'emma@kniplokettiko.nl', 'treatment' => 'Styling', 'appointment_date' => '2026-07-11 15:00:00', 'duration_minutes' => 40, 'status' => 'bevestigd', 'notes' => 'Styling voor feest'],
            ['client_email' => 'yara@example.test', 'employee_email' => 'tom@kniplokettiko.nl', 'treatment' => 'Extensions', 'appointment_date' => '2026-07-12 12:00:00', 'duration_minutes' => 120, 'status' => 'in afwachting', 'notes' => 'Extensions intake'],
        ];

        foreach ($appointments as $appointment) {
            DB::table('appointments')->updateOrInsert(
                ['appointment_date' => $appointment['appointment_date'], 'client_id' => $clientIds[$appointment['client_email']]],
                [
                    'employee_id' => $employeeIds[$appointment['employee_email']],
                    'treatment_id' => $treatmentIds[$appointment['treatment']],
                    'duration_minutes' => $appointment['duration_minutes'],
                    'status' => $appointment['status'],
                    'notes' => $appointment['notes'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
