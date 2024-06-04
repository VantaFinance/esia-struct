<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Vanta\Integration\Esia\Struct\Document\InnNumber;

final readonly class IncomeReferenceDateItemPersonInfo
{
    /**
     * @param non-empty-string  $firstName
     * @param non-empty-string  $lastName
     * @param ?non-empty-string $middleName
     */
    public function __construct(
        public string $firstName,
        public string $lastName,
        public ?string $middleName,
        public InnNumber $inn,
    ) {
    }
}
