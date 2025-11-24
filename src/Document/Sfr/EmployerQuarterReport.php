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
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class EmployerQuarterReport
{
    /**
     * @param non-empty-string $employerNumber
     * @param non-empty-string $employerName
     */
    public function __construct(
        #[SerializedName('entNumber')]
        public string $employerNumber,
        #[SerializedName('entNam')]
        public string $employerName,
        public BigDecimal $paymentsSum,
        public BigDecimal $accumulatedPayment,
    ) {
    }
}
