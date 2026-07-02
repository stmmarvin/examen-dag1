<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKlantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Gebruikers fields
            'voornaam' => ['required', 'string', 'max:100'],
            'achternaam' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'telefoon' => ['required', 'string', 'regex:/^[0-9\s\-\+\(\)]+$/', 'max:20'],
            
            // Klanten fields
            'geboortedatum' => ['nullable', 'date', 'before:today'],
            'adresregel1' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'regex:/^[1-9][0-9]{3}\s?[A-Z]{2}$/i'],
            'plaats' => ['nullable', 'string', 'max:100'],
            
            // Klant_kenmerken fields
            'allergieen' => ['nullable', 'string'],
            'wensen' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom validation messages in Dutch.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'voornaam.required' => 'Vul alle verplichte velden in',
            'voornaam.max' => 'De voornaam mag maximaal :max karakters bevatten',
            'achternaam.required' => 'Vul alle verplichte velden in',
            'achternaam.max' => 'De achternaam mag maximaal :max karakters bevatten',
            'email.required' => 'Vul alle verplichte velden in',
            'email.email' => 'Het email adres is ongeldig',
            'email.max' => 'Het email adres mag maximaal :max karakters bevatten',
            'telefoon.required' => 'Vul alle verplichte velden in',
            'telefoon.regex' => 'Het telefoonnummer is ongeldig',
            'telefoon.max' => 'Het telefoonnummer mag maximaal :max karakters bevatten',
            'geboortedatum.date' => 'De geboortedatum moet een geldige datum zijn',
            'geboortedatum.before' => 'De geboortedatum moet in het verleden liggen',
            'adresregel1.max' => 'Het adres mag maximaal :max karakters bevatten',
            'postcode.regex' => 'De postcode is ongeldig (gebruik formaat: 1234AB)',
            'plaats.max' => 'De plaats mag maximaal :max karakters bevatten',
        ];
    }

    /**
     * Get custom attribute names in Dutch.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'voornaam' => 'voornaam',
            'achternaam' => 'achternaam',
            'email' => 'email adres',
            'telefoon' => 'telefoonnummer',
            'geboortedatum' => 'geboortedatum',
            'adresregel1' => 'adres',
            'postcode' => 'postcode',
            'plaats' => 'plaats',
            'allergieen' => 'allergieën',
            'wensen' => 'wensen',
        ];
    }
}
