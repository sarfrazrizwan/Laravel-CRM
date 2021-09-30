<?php

namespace App\Jobs;

use App\Enums\NewsletterDeliveryStatus;
use App\Mail\NewsletterEmail;
use App\NewsletterRecipient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $newsletterRecipient;
    public function __construct(NewsletterRecipient $newsletterRecipient)
    {
        $this->newsletterRecipient = $newsletterRecipient;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $recipient = $this->newsletterRecipient->recipient;
        $newsletter = $this->newsletterRecipient->newsletter;

        Mail::to($recipient)->send(new NewsletterEmail($newsletter, $this->newsletterRecipient));
        $this->newsletterRecipient->update(['delivery_status' => NewsletterDeliveryStatus::SENT]);
    }
}
