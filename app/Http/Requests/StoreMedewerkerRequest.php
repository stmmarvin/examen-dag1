<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedewerkerRequest extends FormRequest
{
    /**
     * Alleen ingelogde gebruikers mogen medewerkers beheren.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Server-side validatie voor de verplichte velden uit de acceptatiecriteria.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'voornaam' => ['required', 'string', 'max:80'],
            'achternaam' => ['required', 'string', 'max:80'],
            'telefoonnummer' => ['required', 'string', 'max:20'],
            'emailadres' => ['required', 'email', 'max:255', 'unique:personen,emailadres'],
            'functie' => ['required', 'string', 'max:80'],
            'status' => ['required', 'string', 'max:40'],
            'startdatum' => ['nullable', 'date'],
            'werkdagen' => ['nullable', 'string', 'max:120'],
            'werktijden' => ['nullable', 'string', 'max:40'],
            'specialisaties' => ['required', 'array', 'min:1'],
            'specialisaties.*' => ['string', 'in:Knippen,Kleuren,Styling,Extensions'],
        ];
    }

    /**
     * Nederlandse meldingen zoals ze in de Gherkin beschreven zijn.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            '*.required' => 'Vul alle verplichte velden in',
            'specialisaties.required' => 'Vul alle verplichte velden in',
            'specialisaties.min' => 'Vul alle verplichte velden in',
            'emailadres.email' => 'Voer een geldig e-mailadres in',
            'emailadres.unique' => 'Dit e-mailadres is al in gebruik',
        ];
    }
}
