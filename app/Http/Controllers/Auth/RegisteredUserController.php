<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->filled('name') && (! $request->filled('voornaam') || ! $request->filled('achternaam'))) {
            $nameParts = preg_split('/\s+/', trim($request->name), 2);

            $request->merge([
                'voornaam' => $request->voornaam ?: ($nameParts[0] ?? $request->name),
                'achternaam' => $request->achternaam ?: ($nameParts[1] ?? $nameParts[0] ?? $request->name),
            ]);
        }

        $request->validate([
            'name' => ['nullable', 'string', 'min:2', 'max:255'],
            'voornaam' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s\'-]+$/u'],
            'achternaam' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s\'-]+$/u'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc', 'max:255', 'unique:'.User::class],
            'telefoon' => ['nullable', 'regex:/^(06|\+316)[0-9]{8}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'voornaam.regex' => 'Voornaam mag alleen letters bevatten.',
            'voornaam.min' => 'Voornaam moet minimaal 2 letters zijn.',
            'achternaam.regex' => 'Achternaam mag alleen letters bevatten.',
            'achternaam.min' => 'Achternaam moet minimaal 2 letters zijn.',
            'telefoon.regex' => 'Telefoonnummer moet een Nederlands nummer zijn (06... of +316...).',
            'email.email' => 'Voer een geldig e-mailadres in.',
        ]);

        $name = $request->name ?: trim($request->voornaam . ' ' . $request->achternaam);

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'voornaam' => $request->voornaam,
            'achternaam' => $request->achternaam,
            'telefoon' => $request->telefoon,
            'rolename' => 'klant',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
