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

final readonly class PensionCoefficientDataUntil2015
{
    public function __construct(
        #[SerializedName('ns3:ИПК')]
        public BigDecimal $coefficient,
        #[SerializedName('ns3:Стаж')]
        public PensionWorkTimeRecord $workTimeRecord,
    ) {
    }
}
