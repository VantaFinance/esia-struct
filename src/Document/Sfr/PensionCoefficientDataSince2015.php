<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\DateTime\Year;
use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class PensionCoefficientDataSince2015
{
    /**
     * @param list<PensionCoefficientDataSince2015PerEmployer> $byEmployers
     */
    public function __construct(
        #[SerializedName('ns2:Год')]
        public Year $year,
        #[SerializedPath('[ns2:Работодатели][ns3:ИПК]')]
        public BigDecimal $coefficient,
        #[SerializedPath('[ns2:Работодатели][ns2:ПоРаботодателю]')]
        public array $byEmployers,
    ) {
    }
}
