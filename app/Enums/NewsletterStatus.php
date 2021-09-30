<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class NewsletterStatus extends Enum
{
    const PENDING = 1;
    const SENDING = 2;
    const SENT = 3;



    public static function getName($key)
    {
        $name = '';
        switch ($key)
        {
            case self::PENDING :
                $name = 'Pending';
                break;
            case self::SENDING :
                $name = 'Sending';
                break;
            case self::SENT :
                $name = 'Sent';
                break;

        }
        return $name;

    }
}
