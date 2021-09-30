<?php

namespace App\Http\Controllers;

use App\Enums\NewsletterDeliveryStatus;
use App\NewsletterRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsletterRecipientController extends Controller
{
    public function track($id)
    {
        $id = substr($id, 0, -4);

        $newsletterRecipient = NewsletterRecipient::findByUUID($id);
        if ($newsletterRecipient)
            $newsletterRecipient->update(['delivery_status' => NewsletterDeliveryStatus::OPENED]);
        return 'done';

    }
}
