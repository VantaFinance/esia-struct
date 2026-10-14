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

final class RussianInternationalPassport extends Document
{
    /**
     * @param numeric-string $id
     */
    public function __construct(
        public readonly string $id,
        public readonly RussianInternationalPassportSeries $series,
        public readonly RussianInternationalPassportNumber $number,
        #[SerializedName('issueDate')]
        public readonly DateTimeImmutable $issuedAt,
        public readonly ?string $issuedBy,
    ) {
        parent::__construct(DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT);
    }
}
