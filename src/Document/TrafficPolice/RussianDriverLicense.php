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

final class RussianDriverLicense extends Document
{
    /**
     * @param numeric-string $id
     */
    public function __construct(
        public readonly string $id,
        public readonly RussianDriverLicenseSeries $series,
        public readonly RussianDriverLicenseNumber $number,
        #[SerializedName('issueDate')]
        public readonly ?DateTimeImmutable $issuedAt = null,
    ) {
        parent::__construct(DocumentType::RUSSIAN_DRIVER_LICENSE);
    }
}
