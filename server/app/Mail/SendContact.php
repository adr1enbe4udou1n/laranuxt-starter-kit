<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendContact extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var array
     */
    private $validated;

    /**
     * Create a new message instance.
     *
     * @param array $validated
     */
    public function __construct(array $validated)
    {
        $this->validated = $validated;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.contact', $this->validated);
    }
}
