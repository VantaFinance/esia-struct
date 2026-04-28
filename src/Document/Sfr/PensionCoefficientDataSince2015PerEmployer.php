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
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class PensionCoefficientDataSince2015PerEmployer
{
    /**
     * @param list<int> $quarters
     */
    public function __construct(
        #[SerializedPath('[ns2:Работодатель][Наименование]')]
        public string $name,
        #[SerializedPath('[ns2:Работодатель][РегНомер]')]
        public SfrRegistrationNumber $sfrRegistrationNumber,
        #[SerializedName('ns3:Стаж')]
        public ?PensionWorkTimeRecord $workTimeRecord = null,
        #[SerializedPath('[ns2:Период][С]')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public ?DateTimeImmutable $startedAt = null,
        #[SerializedPath('[ns2:Период][По]')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public ?DateTimeImmutable $endedAt = null,
        #[SerializedPath('[ns2:СуммаВыплат]')]
        public ?BigDecimal $incomeSum = null,
        #[SerializedPath('[ns2:НачисленоСВ]')]
        public ?BigDecimal $insurancePaymentsSum = null,
        #[SerializedPath('[ns2:Квартал]')]
        public array $quarters = [],
    ) {
    }
}
