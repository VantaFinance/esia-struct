<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Base;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;

final readonly class SnilsFile
{
    public function __construct(
        #[SerializedPath('[snils]')]
        public SnilsNumber $snils,
    ) {
    }
}
