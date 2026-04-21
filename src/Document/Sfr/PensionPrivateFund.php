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
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final readonly class PensionPrivateFund
{
    /**
     * @param non-empty-string $name
     */
    public function __construct(
        #[SerializedName('ns2:ДатаС')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public DateTimeImmutable $since,
        #[SerializedName('ns2:Наименование')]
        public string $name,
        #[SerializedName('ns2:УчтеноНаИЛС')]
        public PensionPrivateFundBalance $account,
        #[SerializedName('ns2:ПенсионныеНакопления')]
        public PensionPrivateFundBalance $savings,
        #[SerializedPath('[ns2:СуммаПоГарантии][ns2:Восполнение]')]
        public BigDecimal $guaranteesCompensationSum,
        #[SerializedPath('[ns2:СуммаПоГарантии][ns2:Возмещение]')]
        public BigDecimal $guaranteesRefundSum,
        #[SerializedName('ns2:СуммаДохода')]
        public BigDecimal $incomeSum,
        #[SerializedName('ns2:СуммаУдержания')]
        public BigDecimal $deductionSum,
    ) {
    }
}
