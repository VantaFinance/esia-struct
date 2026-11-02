<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

/**
 * @deprecated
 */
#[DiscriminatorDefault(ElectronicWorkbookUnknownEntry::class)]
#[DiscriminatorMap(
    typeProperty: 'type',
    /**@phpstan-ignore-next-line*/
    mapping: [
        1 => ElectronicWorkbookHiringEntry::class,
        2 => ElectronicWorkbookReassignmentEntry::class,
        3 => ElectronicWorkbookRenamingEntry::class,
        4 => ElectronicWorkbookEstablishmentEntry::class,
        5 => ElectronicWorkbookDismissalEntry::class,
        6 => ElectronicWorkbookProhibitionEntry::class,
        7 => ElectronicWorkbookSuspensionEntry::class,
        8 => ElectronicWorkbookResumptionEntry::class,
    ],
)]

abstract readonly class ElectronicWorkbookEntry
{
    /**
     * @param ?non-empty-string $position
     */
    public function __construct(
        public ElectronicWorkbookEntryType $type,
        #[SerializedName('uuid')]
        public Uuid $id,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public DateTimeImmutable $date,
        public ElectronicWorkbookOrganizationInfo $organization,
        public bool $isPartTimeJob = false,
        public ?string $position = null,
    ) {
    }

    final public function isHiring(): bool
    {
        return ElectronicWorkbookEntryType::HIRING == $this->type;
    }

    final public function isReassignment(): bool
    {
        return ElectronicWorkbookEntryType::REASSIGNMENT == $this->type;
    }

    final public function isRenaming(): bool
    {
        return ElectronicWorkbookEntryType::RENAMING == $this->type;
    }

    final public function isEstablishment(): bool
    {
        return ElectronicWorkbookEntryType::ESTABLISHMENT == $this->type;
    }

    final public function isDismissal(): bool
    {
        return ElectronicWorkbookEntryType::DISMISSAL == $this->type;
    }

    final public function isProhibition(): bool
    {
        return ElectronicWorkbookEntryType::PROHIBITION == $this->type;
    }

    final public function isSuspension(): bool
    {
        return ElectronicWorkbookEntryType::SUSPENSION == $this->type;
    }

    final public function isResumption(): bool
    {
        return ElectronicWorkbookEntryType::RESUMPTION == $this->type;
    }

    final public function isUnknown(): bool
    {
        return ElectronicWorkbookEntryType::UNKNOWN == $this->type;
    }
}
