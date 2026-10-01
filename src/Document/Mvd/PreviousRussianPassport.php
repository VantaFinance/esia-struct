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
use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class PreviousRussianPassport extends PreviousDocument implements RussianPassportDocument
{
    /**
     * @param non-empty-string|null $issuedBy
     */
    public function __construct(
        public RussianPassportSeries $series,
        public RussianPassportNumber $number,
        #[SerializedName('issueDate')]
        public DateTimeImmutable $issuedAt,
        public ?string $issuedBy,
        #[SerializedName('issueId')]
        public ?RussianPassportDivisionCode $divisionCode,
        #[SerializedName('passportStatus')]
        public PreviousRussianPassportStatus $status = PreviousRussianPassportStatus::NO_INFORMATION,
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

    public function getDivisionCode(): ?RussianPassportDivisionCode
    {
        return $this->divisionCode;
    }

    #[Ignore]
    public function getDocumentStatus(): RussianPassportDocumentStatus
    {
        return RussianPassportDocumentStatus::fromPreviousRussianPassportStatus($this->status);
    }
}
