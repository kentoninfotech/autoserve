<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AccountWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    // The number of times the Mailable may be attempted.
    public $tries = 3; 

    // The number of seconds to wait before retrying the Mailable.
    public $backoff = 5; // <-- Wait 5 seconds before the next attempt

    // The maximum number of seconds to allow the Mailable to run.
    public $timeout = 60;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new-account-welcome');
    }
}
