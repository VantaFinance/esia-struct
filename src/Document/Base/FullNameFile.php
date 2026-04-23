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

final readonly class FullNameFile
{
    /**
     * @param non-empty-string      $lastName
     * @param non-empty-string      $firstName
     * @param non-empty-string|null $middleName
     */
    public function __construct(
        #[SerializedPath('[ns2:fullName][lastName]')]
        public string $lastName,
        #[SerializedPath('[ns2:fullName][firstName]')]
        public string $firstName,
        #[SerializedPath('[ns2:fullName][middleName]')]
        public ?string $middleName,
    ) {
    }
}
