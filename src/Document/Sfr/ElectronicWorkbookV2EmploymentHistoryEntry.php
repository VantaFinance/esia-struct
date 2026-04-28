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

final readonly class ElectronicWorkbookV2EmploymentHistoryEntry
{
    public function __construct(
        // TODO: Often has trailing newline, need to trim.
        #[SerializedName('ns2:НаименованиеРаботодателя')]
        public string $employerName,
        #[SerializedName('РегНомер')]
        public ?SfrRegistrationNumber $employerRegistrationNumber = null,
        #[SerializedName('ns2:ПериодРаботыС')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public ?DateTimeImmutable $startedAt = null,
        #[SerializedName('ns2:ПериодРаботыПо')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public ?DateTimeImmutable $endedAt = null,
    ) {
    }
}
