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
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Gender;

final readonly class RussianPassport extends Document
{
    /**
     * @param numeric-string        $id
     * @param non-empty-string|null $issuedBy
     * @param non-empty-string|null $birthPlace
     */
    public function __construct(
        public string $id,
        public string $oid,
        public Gender $gender,
        public string $issueId,
        public string $lastName,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'])]
        public DateTimeImmutable $birthDate,
        public string $firstName,
        public ?string $middleName,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'])]
        public DateTimeImmutable $issueDate,
        public string $relevance,
        public ?string $departmentDoc,
        public ?int $receiptDocDate,
        public ?int $validateDateDoc,
        public RussianPassportSeries $series,
        public RussianPassportNumber $number,
        #[SerializedName('issueDate')]
        public DateTimeImmutable $issuedAt,
        public ?string $issuedBy,
        #[SerializedName('issueId')]
        public RussianPassportDivisionCode $divisionCode,
        public ?string $birthPlace,
        public PassportStatus $status,
    ) {
        parent::__construct(DocumentType::RUSSIAN_PASSPORT);
    }
}
