<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaveApprovalConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $statusResult, $comment, $staff_name, $approval_mail;

    public $status = ['Opened', 'Pending', 'Rejected', 'Approved'];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($statusResult, $comment, $staff_name, $approval_mail)
    {
        $this->statusResult = $this->status[$statusResult];
        $this->comment = $comment;
        $this->staff_name = $staff_name;
        $this->approval_mail = $approval_mail;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->approval_mail)
                ->markdown('emails.leaveapprovalconfirmation', [
                    'url' => 'www.leaveapp.ecmterminals.com/leave',
                    'staff_name' => $this->staff_name,
                    'comment' => $this->comment,
                    'statusResult' => $this->statusResult,
                ]
            );

    }
}
