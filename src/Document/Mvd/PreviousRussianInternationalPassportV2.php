<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class PreviousRussianInternationalPassportV2 extends PreviousDocumentV2
{
    /**
     * @param non-empty-string|null $issuedBy
     */
    public function __construct(
        #[SerializedPath('[ns2:baseDoc][series]')]
        public RussianInternationalPassportSeries $series,
        #[SerializedPath('[ns2:baseDoc][number]')]
        public RussianInternationalPassportNumber $number,
        #[SerializedPath('[ns2:baseDoc][issued]')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public DateTimeImmutable $issuedAt,
        #[SerializedPath('[ns2:issuedBy]')]
        public ?string $issuedBy,
        #[SerializedPath('[ns2:passportStatus]')]
        public PreviousRussianPassportStatus $status = PreviousRussianPassportStatus::NO_INFORMATION,
    ) {
        parent::__construct(DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT);
    }
}
