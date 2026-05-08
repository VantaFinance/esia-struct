<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class ElectronicWorkbookV3EmploymentHistoryEntry
{
    public function __construct(
        // TODO: Often has trailing newline, need to trim.
        #[SerializedName('НаименованиеРаботодателя')]
        public string $employerName,
        #[SerializedName('ПериодРаботыС')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public DateTimeImmutable $startedAt,
        #[SerializedName('ПериодРаботыПо')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public DateTimeImmutable $endedAt,
        #[SerializedName('УТ6:РегНомер')]
        public ?SfrRegistrationNumber $employerRegistrationNumber = null,
    ) {
    }
}
