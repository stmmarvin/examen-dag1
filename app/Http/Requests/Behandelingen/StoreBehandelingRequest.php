<?php

namespace App\Http\Requests\Behandelingen;

use Illuminate\Foundation\Http\FormRequest;

class StoreBehandelingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'naam' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:100'],
            'duur_minuten' => ['required', 'integer', 'min:1', 'max:1440'],
            'prijs' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'beschrijving' => ['nullable', 'string', 'max:2000'],
            'aanvullende_informatie' => ['nullable', 'string', 'max:2000'],
            'actief' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'naam.required' => 'Verplichte velden ontbreken.',
            'type.required' => 'Verplichte velden ontbreken.',
            'duur_minuten.required' => 'Verplichte velden ontbreken.',
            'prijs.required' => 'Verplichte velden ontbreken.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'actief' => $this->boolean('actief'),
        ]);
    }
}
