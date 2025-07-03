<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Brick\DateTime\Year;
use Symfony\Component\Serializer\Attribute\SerializedName;

final class PayoutReportYear
{
    /**
     * @param array<PayoutPerMonth> $payouts
     */
    public function __construct(
        #[SerializedName('@ОтчетГод')]
        public Year $year,
        #[SerializedName('НПЮЛ')]
        public PayoutOrganization $organization,
        #[SerializedName('СведСумВыпл')]
        public array $payouts = [],
    ) {
    }
}
