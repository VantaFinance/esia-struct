<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

use InvalidArgumentException;
use Vanta\Integration\Esia\Struct\StringValueObject;

final readonly class RussianPassportDivisionCode implements StringValueObject
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        if (preg_match('/^\d{6}$/', $value)) {
            $value = mb_substr($value, 0, 3) . '-' . mb_substr($value, 3, 3);
        }

        if (!preg_match('/^\d{3}-\d{3}$/m', $value)) {
            throw new InvalidArgumentException('Неверный формат кода подразделения');
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
