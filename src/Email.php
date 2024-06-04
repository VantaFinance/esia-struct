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

final readonly class Email
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Не валидный email: %s', $value));
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
