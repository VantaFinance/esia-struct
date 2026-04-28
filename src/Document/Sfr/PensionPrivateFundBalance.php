<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PensionPrivateFundBalance
{
    public function __construct(
        // ОПС (Обязательное пенсионное страхование)
        #[SerializedName('ns2:ОПС')]
        public ?BigDecimal $mandatoryPensionInsurance = null,
        // МСК (Материнский (семейный) капитал)
        #[SerializedName('ns2:МСК')]
        public ?BigDecimal $maternityCapital = null,
        // ДСВ (Дополнительные страховые взносы)
        #[SerializedName('ns2:ДСВ')]
        public ?BigDecimal $additionalDepositions = null,
        #[SerializedName('ns2:Итого')]
        public ?BigDecimal $total = null,
    ) {
    }
}
