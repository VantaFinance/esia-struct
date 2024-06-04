<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

use Webmozart\Assert\Assert;

final readonly class SnilsNumber
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        Assert::regex($value, '/^\d{3}-\d{3}-\d{3} \d{2}$/', 'Неверный формат данных, ожидаемый формат: XXX-XXX-XXX XX');
    }

    /**
     * @return non-empty-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
