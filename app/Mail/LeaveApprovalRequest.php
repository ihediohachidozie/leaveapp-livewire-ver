<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $staff_id, $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->name = auth()->user()->firstname . ' '. auth()->user()->lastname;
        $this->staff_id = auth()->user()->staff_id;
        $this->email = auth()->user()->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)
        ->markdown('emails.leaveapprovalrequest', [
            'url' => 'www.leaveapp.ecmterminals.com/leave-approval',
            'name' => $this->name,
            'staff_id' => $this->staff_id,
        ]);
    }
}
