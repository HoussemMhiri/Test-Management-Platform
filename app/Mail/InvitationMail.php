<?php

namespace App\Mail;

use App\Models\TestInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $testInvitation;
    public $testSession;
    public $test;
    public function __construct(TestInvitation $testInvitation)
    {
        $this->testInvitation = $testInvitation;
        $this->testSession = $testInvitation->testSession;
        $this->test = $testInvitation->testSession->test;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Test Invitation',
            from: $this->testInvitation->testSession->test->creator->email

        );
    }

    public function content()
    {
        return new Content(
            view: 'app.modules.tests.invitations.mail.invitation-mail',
            with: [
                'testInvitation' => $this->testInvitation,
                'testSession' => $this->testSession,
                'test' => $this->test,
            ]
        );
    }

    public function attachments()
    {
        return [];
    }
}
