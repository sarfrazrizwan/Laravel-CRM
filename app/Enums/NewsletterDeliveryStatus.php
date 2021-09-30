<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class NewsletterDeliveryStatus extends Enum
{
    const PENDING = 1;
    const SENT = 2;
    const OPENED = 3;
}
