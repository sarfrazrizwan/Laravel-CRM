<?php

namespace App\Mail;

use App\Newsletter;
use App\NewsletterRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $newsletter;
    public $newsletterRecipient;
    public function __construct( $newsletter, $newsletterRecipient = null)
    {
        $this->newsletter = $newsletter;
        $this->newsletterRecipient = $newsletterRecipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter')->subject($this->newsletter->subject);
    }
}
