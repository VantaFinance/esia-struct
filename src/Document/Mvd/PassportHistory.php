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

final readonly class PassportHistory extends Document
{
    /**
     * @param list<PreviousDocument> $history
     */
    public function __construct(
        public Uuid $id,
        public string $oid,
        public ?string $error,
        public string $status,
        public string $lastName,
        public string $firstName,
        public ?string $middleName,
        public DateTimeImmutable $birthDate,
        public int $createdOn,
        public int $updatedOn,
        public string $relevance,
        public ?string $departmentDoc,
        public ?int $errorUpdatedOn,
        public ?int $receiptDocDate,
        public ?int $validateDateDoc,
        public int $version,
        public array $history = [],
    ) {
        parent::__construct(DocumentType::PASSPORT_HISTORY);
    }
}
