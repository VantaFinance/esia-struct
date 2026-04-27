<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PensionCoefficientCalculationUntil2015
{
    /**
     * @param list<PensionCoefficientDataUntil2015PerEmployer> $byEmployers
     */
    public function __construct(
        #[SerializedName('ns2:Сумма')]
        public BigDecimal $insurancePaymentsSum,
        #[SerializedName('ns2:РасчетнаяИнформация')]
        public array $byEmployers,
    ) {
    }
}
