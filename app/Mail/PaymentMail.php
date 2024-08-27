<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; // You can pass user data to the mail

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user; // Assign user data to be used in the email
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Account is Now Active')
                    ->view('emails.payment') // Assuming you have a view file named welcome.blade.php in resources/views/emails
                    ->with([
                        'username' => $this->user->username,
                        'activeDate' => $this->user->active_date,
                    ]);
    }
}
