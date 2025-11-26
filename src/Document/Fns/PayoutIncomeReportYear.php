<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Fns;

use Brick\DateTime\Year;
use Symfony\Component\Serializer\Attribute\SerializedName;

final class PayoutIncomeReportYear
{
    /**
     * @param array<PayoutIncomePerMonth> $payouts
     */
    public function __construct(
        #[SerializedName('@ОтчетГод')]
        public Year $year,
        #[SerializedName('НПЮЛ')]
        public ?PayoutIncomeOrganization $organization = null,
        #[SerializedName('СведСумВыпл')]
        public array $payouts = [],
    ) {
    }
}
