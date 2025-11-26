<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr\IndividualInsuranceAccount;

final readonly class IpkQuarter
{
    /**
     * @param int<0,4>                     $quarter
     * @param array<EmployerQuarterReport> $detailEmployer
     */
    public function __construct(
        public int $quarter,
        public array $detailEmployer = []
    ) {
    }
}
