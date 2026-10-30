<?php

namespace Tests\Feature;

use App\Mail\RegistrationEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_a_registration_can_be_saved(): void
    {
        Mail::fake();

        $response = $this->post(route('registrations.store'), [
            'name' => 'Ayu Ramadhani',
            'phone' => '081234567890',
            'email' => 'ayu@email.com',
            'ticket_type' => 'VIP Lounge',
            'quantity' => 2,
            'seat' => 'VIP-12, VIP-13',
        ]);

        $response->assertRedirect(route('registrations.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('registrations', [
            'name' => 'Ayu Ramadhani',
            'email' => 'ayu@email.com',
            'ticket_type' => 'VIP Lounge',
            'quantity' => 2,
        ]);
        Mail::assertSent(RegistrationEmail::class, function (RegistrationEmail $mail): bool {
            return $mail->registration->email === 'ayu@email.com'
                && $mail->registration->ticket_type === 'VIP Lounge';
        });
    }

    public function test_registration_requires_valid_data(): void
    {
        $response = $this->post(route('registrations.store'), [
            'name' => '',
            'email' => 'not-an-email',
            'ticket_type' => 'Invalid ticket',
            'quantity' => 0,
        ]);

        $response->assertSessionHasErrors([
            'name',
            'phone',
            'email',
            'ticket_type',
            'quantity',
            'seat',
        ]);
        $this->assertDatabaseCount('registrations', 0);
    }
}
