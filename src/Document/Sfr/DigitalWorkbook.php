<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

/**
 * Электронная трудовая книжка, полученная из витрины СМЭВ 4 СФР
 */
final class DigitalWorkbook extends Document
{
    /**
     * @param numeric-string                     $oid
     * @param list<DigitalWorkbookEvent>         $events
     * @param list<DigitalWorkbookLaborActivity> $laborActivities
     */
    public function __construct(
        public readonly Uuid $id,
        public readonly string $oid,
        #[SerializedName('statusDoc')]
        public readonly DigitalWorkbookStatus $documentStatus,
        public readonly ?string $status = null,
        public readonly ?string $requestId = null,
        public readonly ?string $apiVersion = null,
        #[SerializedName('createdOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly ?DateTimeImmutable $createdAt = null,
        #[SerializedName('updatedOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly ?DateTimeImmutable $updatedAt = null,
        #[SerializedName('receiptDocDate')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly ?DateTimeImmutable $receivedAt = null,
        public readonly ?string $departmentDoc = null,
        public readonly ?string $nameDoc = null,
        public readonly ?DigitalWorkbookStatement $statement = null,
        #[SerializedName('dateFormation')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public readonly ?DateTimeImmutable $formedAt = null,
        public readonly array $events = [],
        public readonly array $laborActivities = [],
    ) {
        parent::__construct(DocumentType::DIGITAL_WORKBOOK);
    }
}
