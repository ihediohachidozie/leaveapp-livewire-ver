<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserActivationRequest extends Mailable
{
    use Queueable, SerializesModels;


    protected $registeredUser;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->registeredUser = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('infotech@ecmterminals.com')
        ->markdown('emails.useractivationrequest', [
            'url' => 'www.leaveapp.ecmterminals.com/users',
            'firstname' => $this->registeredUser->firstname,
            'lastname' => $this->registeredUser->lastname,
            'staff_id' => $this->registeredUser->staff_id,

        ]);
    }
}
