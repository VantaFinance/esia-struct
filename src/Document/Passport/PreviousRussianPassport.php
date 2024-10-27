<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Passport;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class PreviousRussianPassport extends PreviousDocument
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
    ) {
        parent::__construct(DocumentType::RUSSIAN_PASSPORT);
    }
}
