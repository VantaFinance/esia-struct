<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Gender;

final class RussianPassport extends Document implements RussianPassportDocument
{
    /**
     * @param numeric-string        $id
     * @param non-empty-string|null $issuedBy
     * @param non-empty-string|null $birthPlace
     */
    public function __construct(
        public readonly string $id,
        public readonly string $oid,
        public readonly Gender $gender,
        public readonly string $issueId,
        public readonly string $lastName,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public readonly DateTimeImmutable $birthDate,
        public readonly string $firstName,
        public readonly ?string $middleName,
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public readonly DateTimeImmutable $issueDate,
        public readonly string $relevance,
        public readonly ?string $departmentDoc,
        public readonly ?int $receiptDocDate,
        public readonly ?int $validateDateDoc,
        public readonly RussianPassportSeries $series,
        public readonly RussianPassportNumber $number,
        #[SerializedName('issueDate')]
        public readonly DateTimeImmutable $issuedAt,
        public readonly ?string $issuedBy,
        #[SerializedName('issueId')]
        public readonly RussianPassportDivisionCode $divisionCode,
        public readonly ?string $birthPlace,
        public readonly PassportStatus $status,
    ) {
        parent::__construct(DocumentType::RUSSIAN_PASSPORT);
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

    public function getDivisionCode(): RussianPassportDivisionCode
    {
        return $this->divisionCode;
    }

    #[Ignore]
    public function getDocumentStatus(): RussianPassportDocumentStatus
    {
        return RussianPassportDocumentStatus::fromPassportStatus($this->status);
    }
}
