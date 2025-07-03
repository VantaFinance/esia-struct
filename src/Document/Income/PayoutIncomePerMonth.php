<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Brick\DateTime\Month;
use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PayoutIncomePerMonth
{
    public function __construct(
        #[SerializedName('@Месяц')]
        public Month $month,
        #[SerializedName('@СумВыпл')]
        public BigDecimal $sum,
    ) {
    }
}
