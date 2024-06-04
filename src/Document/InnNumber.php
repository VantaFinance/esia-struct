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

final readonly class InnNumber
{
    /**
     * @param numeric-string $value
     */
    public function __construct(
        public string $value,
    ) {
        Assert::regex($value, '/^\d{10}(\d{2})?$/', 'Налоговый номер должен быть длиной 10 или 12 символов');
    }

    /**
     * @return numeric-string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
