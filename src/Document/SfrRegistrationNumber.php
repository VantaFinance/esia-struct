<?php
/**
 * ESIA Struct
 *
 * @author    Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

use Webmozart\Assert\Assert;

final readonly class SfrRegistrationNumber
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        Assert::regex($value, '/^\d{3}\-?\d{3}\-?\d{6}$/', 'Регистрационный номер СФР/ПФР должен быть в формате ХХХ-ХХХ-ХХХХХХ');
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
