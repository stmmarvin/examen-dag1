<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMedewerkerRequest extends FormRequest
{
    /**
     * Alleen ingelogde gebruikers mogen wijzigingen opslaan.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Update-validatie houdt rekening met het huidige e-mailadres.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $medewerker = $this->route('medewerker');

        return [
            'voornaam' => ['required', 'string', 'max:80'],
            'achternaam' => ['required', 'string', 'max:80'],
            'telefoon' => ['required', 'string', 'max:30'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('medewerkers', 'email')->ignore($medewerker?->id),
            ],
            'personeelsnummer' => [
                'required',
                'string',
                'max:50',
                Rule::unique('medewerkers', 'personeelsnummer')->ignore($medewerker?->id),
            ],
            'functie' => ['required', 'string', 'max:80'],
            'status' => ['required', 'string', 'max:40'],
            'in_dienst_sinds' => ['nullable', 'date'],
            'werkdagen' => ['nullable', 'string', 'max:120'],
            'werktijden' => ['nullable', 'string', 'max:40'],
            'specialisaties' => ['required', 'array', 'min:1'],
            'specialisaties.*' => ['string', 'in:Knippen,Kleuren,Styling,Extensions'],
        ];
    }

    /**
     * Houd de meldingen gelijk aan de acceptatiecriteria.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            '*.required' => 'Vul alle verplichte velden in',
            'specialisaties.required' => 'Vul alle verplichte velden in',
            'specialisaties.min' => 'Vul alle verplichte velden in',
            'email.email' => 'Voer een geldig e-mailadres in',
            'email.unique' => 'Dit e-mailadres is al in gebruik',
            'personeelsnummer.unique' => 'Dit personeelsnummer is al in gebruik',
        ];
    }
}
