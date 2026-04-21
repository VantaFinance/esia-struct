<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PensionCoefficientCalculationUntil2002
{
    public function __construct(
        #[SerializedName('ns2:CреднемесячныйЗаработок')]
        public BigDecimal $averageMonthlyIncome,
        #[SerializedName('ns2:ОбщийСтаж')]
        public PensionWorkTimeRecord $workTimeRecord,
    ) {
    }
}
