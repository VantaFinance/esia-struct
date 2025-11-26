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
use Symfony\Component\Serializer\Annotation\SerializedPath;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class PreviousRussianInternationalPassport extends PreviousDocument
{
    public function __construct(
        public RussianInternationalPassportSeries $series,
        public RussianInternationalPassportNumber $number,
        #[SerializedPath('[issueDate]')]
        public DateTimeImmutable $issuedAt,
        public ?string $issuedBy,
    ) {
        parent::__construct(DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT);
    }
}
