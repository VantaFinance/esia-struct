<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbook;

enum ElectronicWorkbookEntryType: string
{
    case HIRING       = 'HIRING';
    case DISMISSAL    = 'DISMISSAL';
    case REASSIGNMENT = 'REASSIGNMENT';
    case UNKNOWN      = 'UNKNOWN';
}
