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
use Vanta\Integration\Esia\Struct\Gender;

final readonly class GenderFile
{
    public function __construct(
        #[SerializedPath('[ns2:gender][ns2:gender]')]
        public Gender $gender,
    ) {
    }
}
