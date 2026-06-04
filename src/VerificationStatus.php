<?php
/**
 * PosCredit MDM
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

enum VerificationStatus : string
{
    case UNVERIFIED           = 'unverified';
    case VERIFIED_BY_REQUEST  = 'verified_by_request';
    case VERIFIED_BY_VALIDATE = 'verified_by_validate';
}
