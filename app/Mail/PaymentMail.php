<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $activationToken;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $activationToken
     */
    public function __construct($user, $activationToken)
    {
        $this->user = $user;
        $this->activationToken = $activationToken;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $activationLink = url('/activate-account/' . $this->activationToken);

        return $this->subject('Activate Your Account')
                    ->view('emails.payment') // Assuming you have a view file named payment.blade.php in resources/views/emails
                    ->with([
                        'username' => $this->user->username,
                        'activeDate' => $this->user->active_date,
                        'activationLink' => $activationLink, // Pass the activation link to the view
                    ]);
    }
}

