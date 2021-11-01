<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $email, $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($leave, $superuser)
    {
        $this->name = $leave->user->firstname .' '. $leave->user->lastname;
        $this->email = $superuser;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)
        ->markdown('emails.leavestatuschanged', [
            'name' =>$this->name,
            'url' => 'www.leaveapp.ecmterminals.com/leave'
        ]);
    }
}
