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
        $persoonId = $this->route('medewerker')?->persoon_id;

        return [
            'voornaam' => ['required', 'string', 'max:80'],
            'achternaam' => ['required', 'string', 'max:80'],
            'telefoonnummer' => ['required', 'string', 'max:20'],
            'emailadres' => [
                'required',
                'email',
                'max:255',
                Rule::unique('personen', 'emailadres')->ignore($persoonId),
            ],
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
            'emailadres.email' => 'Voer een geldig e-mailadres in',
            'emailadres.unique' => 'Dit e-mailadres is al in gebruik',
        ];
    }
}
