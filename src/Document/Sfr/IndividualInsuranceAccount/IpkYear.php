<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr\IndividualInsuranceAccount;

use Brick\DateTime\Year;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class IpkYear
{
    /**
     * @param array<IpkQuarter> $quarterPeriods
     */
    public function __construct(
        #[SerializedName('currentYear')]
        public Year $year,
        public array $quarterPeriods = []
    ) {
    }
}
