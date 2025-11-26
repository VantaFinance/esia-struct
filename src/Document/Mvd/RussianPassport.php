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
use Symfony\Component\Serializer\Attribute\SerializedName;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class RussianPassport extends Document
{
    /**
     * @param numeric-string        $id
     * @param non-empty-string|null $issuedBy
     * @param non-empty-string|null $birthPlace
     */
    public function __construct(
        public string $id,
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
