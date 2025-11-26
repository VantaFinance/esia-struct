<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\Math\BigDecimal;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final readonly class PreviousEmployerQuarterReport
{
    /**
     * @param non-empty-string           $employerNumber
     * @param non-empty-string           $employerName
     * @param non-empty-array<int<0, 4>> $quarter
     */
    public function __construct(
        #[SerializedName('entNumber')]
        public string $employerNumber,
        #[SerializedName('entNam')]
        public string $employerName,
        public array $quarter,
        public BigDecimal $accPayment,
        public BigDecimal $paymentsSum,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public DateTimeImmutable $beg,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public DateTimeImmutable $end,
        public int $servLenYears,
        public int $servLenMonths,
        public int $servLenDays
    ) {
    }
}
