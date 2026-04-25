<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

enum ElectronicWorkbookV2EventType: string
{
    case HIRING       = '1';
    case REASSIGNMENT = '2';
    case DISMISSAL    = '5';
    case UNKNOWN      = '_';
}
