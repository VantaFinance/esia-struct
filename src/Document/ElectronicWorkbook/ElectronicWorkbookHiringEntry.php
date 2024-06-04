<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;

final readonly class ElectronicWorkbookHiringEntry extends ElectronicWorkbookEntry
{
    /**
     * @param ?non-empty-string $position
     */
    public function __construct(
        #[SerializedName('uuid')]
        public Uuid $id,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public DateTimeImmutable $date,
        public ElectronicWorkbookOrganizationInfo $organization,
        public ?string $position,
        public bool $isPartTimeJob = false,
    ) {
        parent::__construct(ElectronicWorkbookEntryType::HIRING);
    }
}
