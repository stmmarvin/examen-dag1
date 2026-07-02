<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateKlantRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'voornaam' => ['required', 'string', 'max:100'],
            'achternaam' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'telefoon' => ['required', 'string', 'regex:/^[0-9\s\-\+\(\)]+$/', 'max:20'],
            'geboortedatum' => ['nullable', 'date', 'before:today'],
            'adresregel1' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'regex:/^[1-9][0-9]{3}\s?[A-Z]{2}$/i'],
            'plaats' => ['nullable', 'string', 'max:100'],
            'allergieen' => ['nullable', 'string'],
            'wensen' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'voornaam.required' => 'Alle verplichte velden moeten ingevuld zijn',
            'achternaam.required' => 'Alle verplichte velden moeten ingevuld zijn',
            'email.required' => 'Alle verplichte velden moeten ingevuld zijn',
            'telefoon.required' => 'Alle verplichte velden moeten ingevuld zijn',
            'email.email' => 'De ingevoerde gegevens zijn ongeldig',
            'telefoon.regex' => 'De ingevoerde gegevens zijn ongeldig',
            'postcode.regex' => 'De ingevoerde gegevens zijn ongeldig',
            'geboortedatum.before' => 'De geboortedatum moet in het verleden liggen',
        ];
    }
}
