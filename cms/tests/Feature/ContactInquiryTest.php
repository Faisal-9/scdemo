<?php

namespace Tests\Feature;

use App\Mail\ContactInquiryReceived;
use App\Models\ContactInquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactInquiryTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_inquiry_is_saved_and_sent_to_the_configured_mailbox(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Test Visitor',
            'email' => 'visitor@example.com',
            'phone' => '+93 700 000 000',
            'message' => 'Please contact me about an infrastructure project.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('contact_inquiries', ['email' => 'visitor@example.com', 'status' => 'new']);
        Mail::assertSent(ContactInquiryReceived::class, fn (ContactInquiryReceived $mail): bool => $mail->hasTo('comms@statecorps.com'));
    }

    public function test_honeypot_submission_is_rejected(): void
    {
        $response = $this->from('/contact')->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Spam',
            'website' => 'https://example.com',
        ]);

        $response->assertSessionHasErrors('website');
        $this->assertDatabaseCount('contact_inquiries', 0);
    }
}