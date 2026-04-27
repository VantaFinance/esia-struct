<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Base;

use Vanta\Integration\Esia\Struct\Address;

final readonly class RegistrationAddressFile
{
    public function __construct(
        public Address $registrationAddress,
    ) {
    }
}
