<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKlantRequest;
use App\Http\Requests\UpdateKlantRequest;
use App\Models\Gebruiker;
use App\Models\Klant;
use App\Models\KlantKenmerk;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class KlantController extends Controller
{
    /**
     * Display a listing of all klanten.
     * 
     * Returns klanten index view with all klanten from database.
     * 
     * Requirements: 3.1, 3.2, 4.1, 4.2, 4.3
     */
    public function index(): View
    {
        // Get all klanten with their gebruiker relationship (eager loading)
        $klanten = Klant::with('gebruiker')->get();
        
        return view('klanten.index', compact('klanten'));
    }

    /**
     * Show the form for creating a new klant.
     * 
     * Requirements: 1.4
     */
    public function create(): View
    {
        return view('klanten.create');
    }

    /**
     * Store a newly created klant in storage.
     * 
     * Creates both gebruiker and klant records in a transaction.
     * Also creates klant_kenmerken records for allergieen and wensen if provided.
     * 
     * Requirements: 1.1, 1.2, 1.3, 1.5, 2.1-2.6
     */
    public function store(StoreKlantRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Step 1: Create gebruiker record with rol_id=2 for klant role
            $gebruiker = Gebruiker::create([
                'rol_id' => 2,
                'voornaam' => $request->voornaam,
                'achternaam' => $request->achternaam,
                'email' => $request->email,
                'telefoon' => $request->telefoon,
                'wachtwoord' => 'not-used',
                'actief' => true,
            ]);

            // Step 2: Create klant record with gebruiker_id
            $klant = Klant::create([
                'gebruiker_id' => $gebruiker->id,
                'geboortedatum' => $request->geboortedatum,
                'adresregel1' => $request->adresregel1,
                'postcode' => $request->postcode,
                'plaats' => $request->plaats,
            ]);

            // Step 3: Create klant_kenmerken for allergieen if provided
            if ($request->filled('allergieen')) {
                KlantKenmerk::create([
                    'klant_id' => $klant->id,
                    'type' => 'allergie',
                    'titel' => 'Allergieën',
                    'beschrijving' => $request->allergieen,
                    'actief' => true,
                ]);
            }

            // Step 4: Create klant_kenmerken for wensen if provided
            if ($request->filled('wensen')) {
                KlantKenmerk::create([
                    'klant_id' => $klant->id,
                    'type' => 'wens',
                    'titel' => 'Wensen',
                    'beschrijving' => $request->wensen,
                    'actief' => true,
                ]);
            }

            DB::commit();

            // Step 5: Flash success message
            return redirect()
                ->route('klanten.index')
                ->with('success', 'Klant succesvol aangemaakt');

        } catch (QueryException $e) {
            DB::rollBack();
            
            // Log the error details for debugging
            Log::error('Failed to create klant: ' . $e->getMessage(), [
                'request_data' => $request->except(['_token']),
                'exception' => $e
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van de klant. Probeer het opnieuw.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log unexpected errors
            Log::error('Unexpected error creating klant: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van de klant. Probeer het opnieuw.');
        }
    }

    /**
     * Display the specified klant.
     * 
     * Requirements: 3.3
     */
    public function show(Klant $klant): View
    {
        // Eager load gebruiker and klantKenmerken relationships
        $klant->load('gebruiker', 'klantKenmerken');
        
        return view('klanten.show', compact('klant'));
    }

    /**
     * Show the form for editing the specified klant.
     * 
     * Requirements: 5.1, 5.5
     */
    public function edit(Klant $klant): View
    {
        // Eager load the gebruiker and klantKenmerken relationships
        $klant->load('gebruiker', 'klantKenmerken');
        
        return view('klanten.edit', compact('klant'));
    }

    /**
     * Update the specified klant in storage.
     * 
     * Accept UpdateKlantRequest for validation
     * Update existing Klant with validated data
     * Redirect to show or index with success message
     * 
     * Requirements: 5.2, 5.3, 5.4, 5.5, 6.1-6.6
     */
    public function update(UpdateKlantRequest $request, Klant $klant): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Update gebruiker record with validated data
            $klant->gebruiker->update([
                'voornaam' => $request->voornaam,
                'achternaam' => $request->achternaam,
                'email' => $request->email,
                'telefoon' => $request->telefoon,
            ]);

            // Update klant record with validated data
            $klant->update([
                'geboortedatum' => $request->geboortedatum,
                'adresregel1' => $request->adresregel1,
                'postcode' => $request->postcode,
                'plaats' => $request->plaats,
            ]);

            // Update klant_kenmerken for allergieen
            // First, deactivate existing allergieen
            $klant->klantKenmerken()
                ->where('type', 'allergie')
                ->update(['actief' => false]);

            // Add new allergieen if provided
            if ($request->filled('allergieen')) {
                KlantKenmerk::create([
                    'klant_id' => $klant->id,
                    'type' => 'allergie',
                    'titel' => 'Allergieën',
                    'beschrijving' => $request->allergieen,
                    'actief' => true,
                ]);
            }

            // Update klant_kenmerken for wensen
            // First, deactivate existing wensen
            $klant->klantKenmerken()
                ->where('type', 'wens')
                ->update(['actief' => false]);

            // Add new wensen if provided
            if ($request->filled('wensen')) {
                KlantKenmerk::create([
                    'klant_id' => $klant->id,
                    'type' => 'wens',
                    'titel' => 'Wensen',
                    'beschrijving' => $request->wensen,
                    'actief' => true,
                ]);
            }

            DB::commit();

            // Flash success message and redirect to show page
            return redirect()
                ->route('klanten.show', $klant)
                ->with('success', 'Klantgegevens succesvol bijgewerkt');

        } catch (QueryException $e) {
            DB::rollBack();
            
            // Log the error details for debugging
            Log::error('Failed to update klant: ' . $e->getMessage(), [
                'klant_id' => $klant->id,
                'request_data' => $request->except(['_token']),
                'exception' => $e
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de klantgegevens.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log unexpected errors
            Log::error('Unexpected error updating klant: ' . $e->getMessage(), [
                'klant_id' => $klant->id,
                'exception' => $e
            ]);
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van de klantgegevens.');
        }
    }

    /**
     * Remove the specified klant from storage.
     * 
     * Uses route model binding for automatic Klant retrieval.
     * Route model binding automatically handles 404 for non-existent klant.
     * 
     * Requirements: 7.2, 7.3, 8.1, 8.2, 8.3
     */
    public function destroy(Klant $klant): RedirectResponse
    {
        try {
            // Delete the klant from database (cascade will delete gebruiker)
            $klant->delete();

            // Redirect to index with success message
            return redirect()->route('klanten.index')
                ->with('success', 'Klant succesvol verwijderd');

        } catch (QueryException $e) {
            // Log the error details for debugging
            Log::error('Failed to delete klant: ' . $e->getMessage(), [
                'klant_id' => $klant->id,
                'exception' => $e
            ]);
            
            // Return with generic error message for user
            return redirect()->route('klanten.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van de klant. Probeer het opnieuw.');
        }
    }
}
