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
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class PensionCoefficientDataUntil2015PerEmployer
{
    public function __construct(
        #[SerializedPath('[ns2:Работодатель][Наименование]')]
        public string $name,
        #[SerializedPath('[ns2:Работодатель][РегНомер]')]
        public SfrRegistrationNumber $sfrRegistrationNumber,
        #[SerializedPath('[ns2:ДанныеПоПериоду][ns3:Стаж]')]
        public ?PensionWorkTimeRecord $workTimeRecord = null,
        #[SerializedPath('[ns2:ДанныеПоПериоду][ns2:Период][С]')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public ?DateTimeImmutable $startedAt = null,
        #[SerializedPath('[ns2:ДанныеПоПериоду][ns2:Период][По]')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public ?DateTimeImmutable $endedAt = null,
        #[SerializedPath('[ns2:ДанныеПоПериоду][ns2:СуммаСВ]')]
        public ?BigDecimal $insurancePaymentsSum = null,
    ) {
    }
}
