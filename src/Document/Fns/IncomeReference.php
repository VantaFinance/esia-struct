<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Fns;

use Brick\DateTime\Year;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final class IncomeReference extends Document
{
    /**
     * @param list<IncomeReferenceDataItem> $data
     */
    public function __construct(
        public readonly ?Uuid $id,
        public readonly ?Year $year,
        public readonly ?int $version,
        public readonly array $data = [],
    ) {
        parent::__construct(DocumentType::INCOME_REFERENCE);
    }

    /**
     * @param non-empty-list<non-empty-string> $types
     *
     * @return array<IncomeReferenceBase64File>
     */
    public function getFilesByTypes(array $types): array
    {
        return array_merge(
            ...array_map(static fn (IncomeReferenceDataItem $e): array => $e->getFilesByTypes($types), $this->data)
        );
    }
}
