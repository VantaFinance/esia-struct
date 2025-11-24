<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\Math\BigDecimal;

final readonly class EmployerQuarterReport
{
    /**
     * @param non-empty-string $employerNumber
     * @param non-empty-string $employerName
     */
    public function __construct(
        public string $employerNumber,
        public string $employerName,
        public BigDecimal $paymentsSum,
        public BigDecimal $accumulatedPayment,
    ) {
    }
}
