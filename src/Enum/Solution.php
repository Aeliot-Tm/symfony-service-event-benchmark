<?php

declare(strict_types=1);

namespace App\Enum;

enum Solution: string
{
    case EVENT = 'event';
    case MESSENGER = 'messenger';
    case SERVICE_DIRECT = 'service_direct';
    case SERVICE_ITERATOR = 'service_iterator';
}
