<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\DriverLicense;

use InvalidArgumentException;
use Stringable;

final readonly class RussianDriverLicenseSeries implements Stringable
{
    /**
     * @param non-empty-string $value
     */
    public function __construct(
        public string $value,
    ) {
        if (!preg_match('/^\d{4}$/', $value) && !mb_ereg('\d{2}[а-яА-Я]{2}', $value)) {
            throw new InvalidArgumentException('Ожидаем 4 цифры или 2 цифры и 2 буквы');
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
