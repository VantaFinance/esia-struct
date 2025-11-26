<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Fns;

use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\KppNumber;

final readonly class IncomeReferenceDateItemOrganizationInfo
{
    /**
     * @param non-empty-string $fullName
     */
    public function __construct(
        public string $fullName,
        public InnNumber $inn,
        public KppNumber $kpp,
    ) {
    }
}
