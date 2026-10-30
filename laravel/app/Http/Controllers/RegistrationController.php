<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationEmail;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    /**
     * Save a ticket registration.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'ticket_type' => ['required', 'string', 'in:VIP Lounge,Gold Zone,Regular Seat'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'seat' => ['required', 'string', 'max:255'],
        ]);

        $registration = Registration::create($validated);

        Mail::to($registration->email)->send(new RegistrationEmail($registration));
        dd("gas");

        return to_route('registrations.create')
            ->with('success', 'Pendaftaran tiket berhasil disimpan.');
    }
}
