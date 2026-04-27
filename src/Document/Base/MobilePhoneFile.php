<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Base;

use Brick\PhoneNumber\PhoneNumber;
use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class MobilePhoneFile
{
    public function __construct(
        #[SerializedPath('[mobilePhone]')]
        public PhoneNumber $phoneNumber,
    ) {
    }
}
