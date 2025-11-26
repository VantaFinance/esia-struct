<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

enum PreviousRussianPassportStatus: string
{
    case VALID          = 'valid';
    case NO_INFORMATION = 'noInformation';
    case EXPIRED        = 'expired';
}
