<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class WorkbookEmploymentHistoryEntry
{
    public function __construct(
        // TODO: Often has trailing newline, need to trim.
        #[SerializedName('ns2:НаименованиеРаботодателя')]
        public string $employerName,
        #[SerializedName('РегНомер')]
        public SfrRegistrationNumber $employerRegistrationNumber,
        #[SerializedName('ns2:ПериодРаботыС')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public DateTimeImmutable $startedAt,
        #[SerializedName('ns2:ПериодРаботыПо')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public ?DateTimeImmutable $endedAt,
    ) {
    }
}
