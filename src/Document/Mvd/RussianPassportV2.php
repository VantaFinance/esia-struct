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
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class RussianPassportV2 extends Document implements RussianPassportDocument
{
    /**
     * @param non-empty-string|null $issuedBy
     */
    public function __construct(
        #[SerializedPath('[ns2:baseDoc][series]')]
        public RussianPassportSeries $series,
        #[SerializedPath('[ns2:baseDoc][number]')]
        public RussianPassportNumber $number,
        #[SerializedPath('[ns2:baseDoc][issued]')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public DateTimeImmutable $issuedAt,
        #[SerializedPath('[ns2:issuedBy]')]
        public ?string $issuedBy = null,
        #[SerializedPath('[ns2:issueId]')]
        public ?RussianPassportDivisionCode $divisionCode = null,
    ) {
        parent::__construct(DocumentType::RUSSIAN_PASSPORT_V2);
    }

    public function getSeries(): RussianPassportSeries
    {
        return $this->series;
    }

    public function getNumber(): RussianPassportNumber
    {
        return $this->number;
    }

    public function getIssuedAt(): DateTimeImmutable
    {
        return $this->issuedAt;
    }

    /**
     * @return non-empty-string|null
     */
    public function getIssuedBy(): ?string
    {
        return $this->issuedBy;
    }

    public function getDivisionCode(): ?RussianPassportDivisionCode
    {
        return $this->divisionCode;
    }

    /**
     * RussianPassportV2 has no status field in the ESIA payload.
     */
    #[Ignore]
    public function getDocumentStatus(): RussianPassportDocumentStatus
    {
        return RussianPassportDocumentStatus::UNKNOWN;
    }
}
