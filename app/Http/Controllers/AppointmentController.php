<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Behandelingen\Behandeling;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;

<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Behandelingen\Behandeling;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
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

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('appointment_date', [
                $request->start_date,
                $request->end_date . ' 23:59:59',
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
        $employees = Employee::orderBy('name')->get();
        $clients = Client::all();
        $treatments = Behandeling::where('actief', true)->get();

        return view('appointments.overview', compact('appointments', 'employees', 'clients', 'treatments'));
    }

    public function createAsClient()
    {
        $employees = Employee::orderBy('name')->get();
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();
        $client = Client::firstOrNew(['user_id' => auth()->id()]);

        if (! $client->exists) {
            $client->first_name = auth()->user()->voornaam ?? auth()->user()->name;
            $client->last_name = auth()->user()->achternaam ?? '';
            $client->phone = auth()->user()->telefoon ?? auth()->user()->email;
            $client->email = auth()->user()->email;
            $client->save();
        }

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
        $employee = Employee::where('email', auth()->user()->email)->first();
        $employeeId = $employee?->id ?? auth()->id();

        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->where('employee_id', $employeeId)
            ->orderBy('appointment_date', 'asc')
            ->paginate(10);

        return view('appointments.view-as-employee', compact('appointments'));
    }

    public function editAsClient()
    {
        $client = Client::where('user_id', auth()->id())->first();

        if (! $client) {
            return redirect()->route('appointments.create-as-client')
                ->with('info', 'U heeft nog geen afspraken. Maak uw eerste afspraak aan.');
        }

        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->where('client_id', $client->id)
            ->whereIn('status', ['bevestigd', 'in afwachting'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        $employees = Employee::orderBy('name')->get();
        $treatments = Behandeling::where('actief', true)->get();

        return view('appointments.edit-as-client', compact('appointments', 'employees', 'treatments'));
    }

    public function create()
    {
        $clients = Client::orderBy('last_name')->get();
        $employees = Employee::orderBy('name')->get();
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();

        return view('appointments.create', compact('clients', 'employees', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'treatment_id' => 'required|exists:behandelingen,id',
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

        $treatment = Behandeling::findOrFail($validated['treatment_id']);
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        Appointment::create([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_id' => $validated['treatment_id'],
            'appointment_date' => $appointmentDateTime,
            'duration_minutes' => $treatment->duur_minuten,
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
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();

        return view('appointments.edit', compact('appointment', 'clients', 'employees', 'treatments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->status === 'geannuleerd') {
            return back()->with('error', 'Deze afspraak is geannuleerd en kan niet meer worden gewijzigd.');
        }

        if ($appointment->appointment_date < now()) {
            return back()->with('error', 'Deze afspraak is al verstreken en kan niet meer worden gewijzigd.');
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'treatment_id' => 'required|exists:behandelingen,id',
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

        $treatment = Behandeling::findOrFail($validated['treatment_id']);
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        $appointment->update([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_id' => $validated['treatment_id'],
            'appointment_date' => $appointmentDateTime,
            'duration_minutes' => $treatment->duur_minuten,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Afspraak succesvol bijgewerkt!');
    }

    public function destroy(Appointment $appointment)
    {
        if (! $appointment) {
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
class AppointmentController extends Controller
{
    public function index()
    {
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

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('appointment_date', [
                $request->start_date,
                $request->end_date . ' 23:59:59',
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
        $employees = Employee::orderBy('name')->get();
        $clients = Client::all();
        $treatments = Behandeling::where('actief', true)->get();

        return view('appointments.overview', compact('appointments', 'employees', 'clients', 'treatments'));
    }

    public function createAsClient()
    {
        $employees = Employee::orderBy('name')->get();
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();
        $client = Client::firstOrNew(['user_id' => auth()->id()]);

        if (! $client->exists) {
            $client->first_name = auth()->user()->voornaam ?? auth()->user()->name;
            $client->last_name = auth()->user()->achternaam ?? '';
            $client->phone = auth()->user()->telefoon ?? auth()->user()->email;
            $client->email = auth()->user()->email;
            $client->save();
        }

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
        $employee = Employee::where('email', auth()->user()->email)->first();
        $employeeId = $employee?->id ?? auth()->id();

        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->where('employee_id', $employeeId)
            ->orderBy('appointment_date', 'asc')
            ->paginate(10);

        return view('appointments.view-as-employee', compact('appointments'));
    }

    public function editAsClient()
    {
        $client = Client::where('user_id', auth()->id())->first();

        if (! $client) {
            return redirect()->route('appointments.create-as-client')
                ->with('info', 'U heeft nog geen afspraken. Maak uw eerste afspraak aan.');
        }

        $appointments = Appointment::with(['client', 'employee', 'treatment'])
            ->where('client_id', $client->id)
            ->whereIn('status', ['bevestigd', 'in afwachting'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        $employees = Employee::orderBy('name')->get();
        $treatments = Behandeling::where('actief', true)->get();

        return view('appointments.edit-as-client', compact('appointments', 'employees', 'treatments'));
    }

    public function create()
    {
        $clients = Client::orderBy('last_name')->get();
        $employees = Employee::orderBy('name')->get();
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();

        return view('appointments.create', compact('clients', 'employees', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'treatment_id' => 'required|exists:behandelingen,id',
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

        $treatment = Behandeling::findOrFail($validated['treatment_id']);
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        Appointment::create([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_id' => $validated['treatment_id'],
            'appointment_date' => $appointmentDateTime,
            'duration_minutes' => $treatment->duur_minuten,
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
        $treatments = Behandeling::where('actief', true)->orderBy('naam')->get();

        return view('appointments.edit', compact('appointment', 'clients', 'employees', 'treatments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if ($appointment->status === 'geannuleerd') {
            return back()->with('error', 'Deze afspraak is geannuleerd en kan niet meer worden gewijzigd.');
        }

        if ($appointment->appointment_date < now()) {
            return back()->with('error', 'Deze afspraak is al verstreken en kan niet meer worden gewijzigd.');
        }

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'employee_id' => 'required|exists:employees,id',
            'treatment_id' => 'required|exists:behandelingen,id',
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

        $treatment = Behandeling::findOrFail($validated['treatment_id']);
        $appointmentDateTime = $validated['appointment_date'] . ' ' . $validated['appointment_time'];

        $appointment->update([
            'user_id' => auth()->id(),
            'client_id' => $validated['client_id'],
            'employee_id' => $validated['employee_id'],
            'treatment_id' => $validated['treatment_id'],
            'appointment_date' => $appointmentDateTime,
            'duration_minutes' => $treatment->duur_minuten,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('appointments.index')
            ->with('success', 'Afspraak succesvol bijgewerkt!');
    }

    public function destroy(Appointment $appointment)
    {
        if (! $appointment) {
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
