<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\TrafficPolice;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class RussianDriverLicense extends Document
{
    /**
     * @param numeric-string $id
     */
    public function __construct(
        public string $id,
        public RussianDriverLicenseSeries $series,
        public RussianDriverLicenseNumber $number,
        #[SerializedName('issueDate')]
        public ?DateTimeImmutable $issuedAt = null,
    ) {
        parent::__construct(DocumentType::RUSSIAN_DRIVER_LICENSE);
    }
}
