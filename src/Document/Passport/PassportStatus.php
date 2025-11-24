<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Passport;

enum PassportStatus: string
{
    case VERIFIED_BY_VALIDATE = 'verified_by_validate';
    case UNVERIFIED           = 'unverified';
}
