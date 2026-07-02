<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->user = User::factory()->create();
        $this->client = Client::create([
            'user_id' => $this->user->id,
            'first_name' => 'Test',
            'last_name' => 'Client',
            'email' => 'client@test.com',
            'phone' => '0612345678',
        ]);
        $this->employee = Employee::create([
            'name' => 'Test Employee',
            'email' => 'employee@test.com',
            'phone' => '0687654321',
        ]);
        $this->treatment = Treatment::create([
            'name' => 'Test Treatment',
            'description' => 'Test description',
            'duration_minutes' => 60,
            'price' => 50.00,
        ]);
    }

    public function test_authenticated_user_can_view_appointments_index()
    {
        $this->actingAs($this->user)
            ->get(route('appointments.index'))
            ->assertStatus(200)
            ->assertViewIs('appointments.index');
    }

    public function test_guest_cannot_view_appointments_index()
    {
        $this->get(route('appointments.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_appointment()
    {
        $futureDate = now()->addDays(5)->format('Y-m-d');
        
        $this->actingAs($this->user)
            ->post(route('appointments.store'), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => $futureDate,
                'appointment_time' => '10:00',
                'notes' => 'Test appointment',
            ])
            ->assertRedirect(route('appointments.edit-as-client'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'status' => 'bevestigd',
        ]);
    }

    public function test_cannot_create_appointment_with_past_date()
    {
        $pastDate = now()->subDays(5)->format('Y-m-d');
        
        $this->actingAs($this->user)
            ->post(route('appointments.store'), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => $pastDate,
                'appointment_time' => '10:00',
            ])
            ->assertSessionHasErrors('appointment_date');

        $this->assertDatabaseCount('appointments', 0);
    }

    public function test_cannot_create_appointment_without_required_fields()
    {
        $this->actingAs($this->user)
            ->post(route('appointments.store'), [])
            ->assertSessionHasErrors(['client_id', 'employee_id', 'treatment_id', 'appointment_date', 'appointment_time']);
    }

    public function test_authenticated_user_can_update_future_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'appointment_date' => now()->addDays(5),
            'duration_minutes' => 60,
            'status' => 'bevestigd',
        ]);

        $newDate = now()->addDays(7)->format('Y-m-d');

        $this->actingAs($this->user)
            ->put(route('appointments.update', $appointment), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => $newDate,
                'appointment_time' => '14:00',
                'status' => 'bevestigd',
                'notes' => 'Updated appointment',
            ])
            ->assertRedirect(route('appointments.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'notes' => 'Updated appointment',
        ]);
    }

    public function test_cannot_update_cancelled_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'appointment_date' => now()->addDays(5),
            'duration_minutes' => 60,
            'status' => 'geannuleerd',
        ]);

        $this->actingAs($this->user)
            ->put(route('appointments.update', $appointment), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => now()->addDays(7)->format('Y-m-d'),
                'appointment_time' => '14:00',
                'status' => 'bevestigd',
            ])
            ->assertSessionHas('error', 'Deze afspraak is geannuleerd en kan niet meer worden gewijzigd.');
    }

    public function test_cannot_update_past_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'appointment_date' => now()->subDays(5),
            'duration_minutes' => 60,
            'status' => 'bevestigd',
        ]);

        $this->actingAs($this->user)
            ->put(route('appointments.update', $appointment), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => now()->addDays(7)->format('Y-m-d'),
                'appointment_time' => '14:00',
                'status' => 'bevestigd',
            ])
            ->assertSessionHas('error', 'Deze afspraak is al verstreken en kan niet meer worden gewijzigd.');
    }

    public function test_authenticated_user_can_delete_future_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'appointment_date' => now()->addDays(5),
            'duration_minutes' => 60,
            'status' => 'bevestigd',
        ]);

        $this->actingAs($this->user)
            ->delete(route('appointments.destroy', $appointment))
            ->assertSessionHas('success', 'Afspraak succesvol geannuleerd!');

        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
        ]);
    }

    public function test_cannot_delete_cancelled_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'appointment_date' => now()->addDays(5),
            'duration_minutes' => 60,
            'status' => 'geannuleerd',
        ]);

        $this->actingAs($this->user)
            ->delete(route('appointments.destroy', $appointment))
            ->assertSessionHas('error', 'Deze afspraak is al geannuleerd.');

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
        ]);
    }

    public function test_cannot_delete_past_appointment()
    {
        $appointment = Appointment::create([
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
            'employee_id' => $this->employee->id,
            'treatment_id' => $this->treatment->id,
            'appointment_date' => now()->subDays(5),
            'duration_minutes' => 60,
            'status' => 'bevestigd',
        ]);

        $this->actingAs($this->user)
            ->delete(route('appointments.destroy', $appointment))
            ->assertSessionHas('error', 'Afspraken uit het verleden kunnen niet worden geannuleerd.');

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
        ]);
    }

    public function test_appointment_is_linked_to_user_who_created_it()
    {
        $futureDate = now()->addDays(5)->format('Y-m-d');
        
        $response = $this->actingAs($this->user)
            ->post(route('appointments.store'), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => $futureDate,
                'appointment_time' => '10:00',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'user_id' => $this->user->id,
            'client_id' => $this->client->id,
        ]);
    }

    public function test_appointment_inherits_duration_from_treatment()
    {
        $futureDate = now()->addDays(5)->format('Y-m-d');
        
        $response = $this->actingAs($this->user)
            ->post(route('appointments.store'), [
                'client_id' => $this->client->id,
                'employee_id' => $this->employee->id,
                'treatment_id' => $this->treatment->id,
                'appointment_date' => $futureDate,
                'appointment_time' => '10:00',
            ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('appointments', [
            'treatment_id' => $this->treatment->id,
            'duration_minutes' => $this->treatment->duration_minutes,
        ]);
    }

    public function test_can_view_appointment_overview_page()
    {
        $this->actingAs($this->user)
            ->get(route('appointments.overview'))
            ->assertStatus(200)
            ->assertViewIs('appointments.overview');
    }

    public function test_can_view_create_as_client_page()
    {
        $this->actingAs($this->user)
            ->get(route('appointments.create-as-client'))
            ->assertStatus(200)
            ->assertViewIs('appointments.create-as-client');
    }

    public function test_can_view_edit_as_client_page()
    {
        $this->actingAs($this->user)
            ->get(route('appointments.edit-as-client'))
            ->assertStatus(200)
            ->assertViewIs('appointments.edit-as-client');
    }

    public function test_can_view_test_unhappy_paths_page()
    {
        $this->actingAs($this->user)
            ->get(route('appointments.test-unhappy-paths'))
            ->assertStatus(200)
            ->assertViewIs('appointments.test-unhappy-paths');
    }
}
