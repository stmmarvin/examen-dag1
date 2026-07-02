<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Behandelingen\Behandeling;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        // Simple list page without modals
        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->orderBy('appointment_date', 'asc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    public function manage()
    {
        return view('appointments.manage');
    }

    public function overview(Request $request)
    {
        $query = Appointment::with(['client', 'employee', 'treatment', 'user'])
            ->orderBy('appointment_date', 'asc');

        // Filters
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('appointment_date', [
                $request->start_date,
                $request->end_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('treatment_id')) {
            $query->where('treatment_id', $request->treatment_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $appointments = $query->paginate(10);

        $employees = Employee::all();
        $clients = Client::all();
        $treatments = Treatment::all();

        return view('appointments.overview', compact('appointments', 'employees', 'clients', 'treatments'));
    }

    public function createAsClient()
    {
        // Get employees from users table with role 'medewerker' 
        $employees = User::where('rolename', 'medewerker')->orderBy('name')->get();
        
        // Get behandelingen instead of treatments
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();
        
        // Get or create client for logged in user
        $client = Client::firstOrCreate(
            ['user_id' => auth()->id()],
            [
                'first_name' => auth()->user()->voornaam ?? auth()->user()->name,
                'last_name' => auth()->user()->achternaam ?? '',
                'phone' => auth()->user()->telefoon ?? auth()->user()->email,
                'email' => auth()->user()->email,
            ]
        );
        
        return view('appointments.create-as-client', compact('employees', 'treatments', 'client'));
    }

    public function deleteAsEmployee()
    {
        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
        return view('appointments.delete-as-employee', compact('appointments'));
    }

    public function viewAsEmployee()
    {
        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->where('employee_id', auth()->user()->id ?? 1)
            ->orderBy('appointment_date', 'asc')
            ->paginate(10);
        return view('appointments.view-as-employee', compact('appointments'));
    }

    public function editAsClient()
    {
        // Get appointments for logged-in user's client
        $client = Client::where('user_id', auth()->id())->first();
        
        if (!$client) {
            return redirect()->route('appointments.create-as-client')
                ->with('info', 'U heeft nog geen afspraken. Maak uw eerste afspraak aan.');
        }
        
        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->where('client_id', $client->id)
            ->whereIn('status', ['bevestigd', 'in afwachting'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
            
        $employees = Employee::all();
        $treatments = Treatment::all();
        
        return view('appointments.edit-as-client', compact('appointments', 'employees', 'treatments'));
    }

    public function create()
    {
        $clients = Client::orderBy('last_name')->get();
        $employees = Employee::orderBy('name')->get();
        $treatments = Treatment::orderBy('name')->get();

        return view('appointments.create', compact('clients', 'employees', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string',
        ], [
            'client_id.required' => 'Selecteer een klant.',
            'employee_id.required' => 'Selecteer een medewerker.',
            'treatment_id.required' => 'Selecteer een behandeling.',
            'appointment_date.required' => 'Selecteer een datum.',
            'appointment_date.after_or_equal' => 'De datum moet vandaag of in de toekomst zijn.',
            'appointment_time.required' => 'Selecteer een tijd.',
        ]);

        $treatment = Treatment::findOrFail($validated['treatment_id']);
        
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        Appointment::create([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_id' => $validated['treatment_id'],
            'appointment_date' => $appointmentDateTime,
            'duration_minutes' => $treatment->duration_minutes,
            'status' => 'bevestigd',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('appointments.edit-as-client')
            ->with('success', 'Afspraak succesvol aangemaakt!');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['client', 'employee', 'treatment']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $clients = Client::orderBy('last_name')->get();
        $employees = Employee::orderBy('name')->get();
        $treatments = Treatment::orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'clients', 'employees', 'treatments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Check if appointment can be updated (not cancelled or past)
        if ($appointment->status === 'geannuleerd') {
            return back()->with('error', 'Deze afspraak is geannuleerd en kan niet meer worden gewijzigd.');
        }
        
        if ($appointment->appointment_date < now()) {
            return back()->with('error', 'Deze afspraak is al verstreken en kan niet meer worden gewijzigd.');
        }
        
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|in:bevestigd,in afwachting,geannuleerd,voltooid',
            'notes' => 'nullable|string',
        ], [
            'client_id.required' => 'Selecteer een klant.',
            'employee_id.required' => 'Selecteer een medewerker.',
            'treatment_id.required' => 'Selecteer een behandeling.',
            'appointment_date.required' => 'Selecteer een datum.',
            'appointment_time.required' => 'Selecteer een tijd.',
        ]);

        $treatment = Treatment::findOrFail($validated['treatment_id']);
        
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        $appointment->update([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_id' => $validated['treatment_id'],
            'appointment_date' => $appointmentDateTime,
            'duration_minutes' => $treatment->duration_minutes,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Afspraak succesvol bijgewerkt!');
    }

    public function destroy(Appointment $appointment)
    {
        // Check if appointment exists and can be deleted
        if (!$appointment) {
            return back()->with('error', 'Deze afspraak bestaat niet meer.');
        }
        
        if ($appointment->status === 'geannuleerd') {
            return back()->with('error', 'Deze afspraak is al geannuleerd.');
        }
        
        if ($appointment->appointment_date < now()) {
            return back()->with('error', 'Afspraken uit het verleden kunnen niet worden geannuleerd.');
        }
        
        $appointment->delete();

        return back()->with('success', 'Afspraak succesvol geannuleerd!');
    }

    public function testUnhappyPaths()
    {
        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('appointments.test-unhappy-paths', compact('appointments'));
    }
}
