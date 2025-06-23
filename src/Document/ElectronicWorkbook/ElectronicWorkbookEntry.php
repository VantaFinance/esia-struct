<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook;

use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

#[DiscriminatorDefault(ElectronicWorkbookUnknownEntry::class)]
#[DiscriminatorMap(
    typeProperty: 'type',
    /**@phpstan-ignore-next-line*/
    mapping: [
        1 => ElectronicWorkbookHiringEntry::class,
        2 => ElectronicWorkbookReassignmentEntry::class,
        5 => ElectronicWorkbookDismissalEntry::class,
    ],
)]
abstract readonly class ElectronicWorkbookEntry
{
    public function __construct(
        public ElectronicWorkbookEntryType $type,
    ) {
    }

    final public function isHiring(): bool
    {
        return ElectronicWorkbookEntryType::HIRING == $this->type;
    }

    final public function isDismissal(): bool
    {
        return ElectronicWorkbookEntryType::DISMISSAL == $this->type;
    }

    final public function isReassignment(): bool
    {
        return ElectronicWorkbookEntryType::REASSIGNMENT == $this->type;
    }

    final public function isUnknown(): bool
    {
        return ElectronicWorkbookEntryType::UNKNOWN == $this->type;
    }
}
