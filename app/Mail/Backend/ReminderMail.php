<?php

namespace App\Mail\Backend;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $emailTemplate;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailTemplate)
    {
        $this->emailTemplate = $emailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('backend.mail.test');
    }
}
