<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

use Vanta\Integration\Esia\Struct\Email;

final readonly class EmailWrapper
{
    public function __construct(
        public string $raw,
        public Email $email,
    ) {
    }
}
