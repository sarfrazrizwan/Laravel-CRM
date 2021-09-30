<?php

namespace App\Enums;

use BenSampo\Enum\Enum;


final class UserType extends Enum
{
    const USER =  'user';
    const SUPERVISOR = 'supervisor';
    const COMPANY_ADMIN = 'company-admin';
    const SUPER_ADMIN = 'super-admin';
}
