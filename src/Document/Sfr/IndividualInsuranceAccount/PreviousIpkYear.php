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

final readonly class PreviousIpkYear
{
    /**
     * @param array<PreviousEmployerQuarterReport> $detailPeriods
     */
    public function __construct(
        public Year $year,
        public array $detailPeriods = []
    ) {
    }
}
