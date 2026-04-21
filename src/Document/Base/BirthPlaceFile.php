<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Base;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class BirthPlaceFile
{
    /**
     * @param non-empty-string $birthPlace
     */
    public function __construct(
        #[SerializedPath('[ns2:birthPlace][ns2:birthPlace]')]
        public string $birthPlace,
    ) {
    }
}
