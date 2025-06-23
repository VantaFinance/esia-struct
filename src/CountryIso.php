<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

use InvalidArgumentException;

final readonly class CountryIso
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        if (!preg_match('/^[a-zA-Z]{3}$/', $value)) {
            throw new InvalidArgumentException('Invalid country ISO code, must be an ISO 3166-1 alpha-3 code');
        }
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
