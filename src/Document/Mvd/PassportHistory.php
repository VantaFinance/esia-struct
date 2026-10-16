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
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final class PassportHistory extends Document
{
    /**
     * @param list<PreviousDocument> $history
     */
    public function __construct(
        public readonly Uuid $id,
        public readonly string $oid,
        public readonly ?string $error,
        public readonly string $status,
        public readonly string $lastName,
        public readonly string $firstName,
        public readonly ?string $middleName,
        public readonly DateTimeImmutable $birthDate,
        public readonly int $createdOn,
        public readonly int $updatedOn,
        public readonly string $relevance,
        public readonly ?string $departmentDoc,
        public readonly ?int $errorUpdatedOn,
        public readonly ?int $receiptDocDate,
        public readonly ?int $validateDateDoc,
        public readonly int $version,
        public readonly array $history = [],
    ) {
        parent::__construct(DocumentType::PASSPORT_HISTORY);
    }
}
