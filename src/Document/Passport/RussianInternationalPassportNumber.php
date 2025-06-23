<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Passport;

use Webmozart\Assert\Assert;

final readonly class RussianInternationalPassportNumber
{
    /**
     * @param numeric-string $value
     */
    public function __construct(
        public string $value,
    ) {
        Assert::regex($value, '/^\d{7}$/', 'Неверный формат номера документа, ожидается 7 цифр');
    }

    /**
     * @return numeric-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
