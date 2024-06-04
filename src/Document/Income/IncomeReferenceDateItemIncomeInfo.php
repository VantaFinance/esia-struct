<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Brick\Math\BigDecimal;

final readonly class IncomeReferenceDateItemIncomeInfo
{
    public function __construct(
        public BigDecimal $rate,
        public BigDecimal $income,
        public BigDecimal $tax,
    ) {
    }
}
