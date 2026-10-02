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
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

#[DiscriminatorDefault(DigitalWorkbookUnknownEvent::class)]
#[DiscriminatorMap(
    typeProperty: 'type',
    /**@phpstan-ignore-next-line*/
    mapping: [
        '1' => DigitalWorkbookHiringEvent::class,
        '2' => DigitalWorkbookReassignmentEvent::class,
        '5' => DigitalWorkbookDismissalEvent::class,
    ],
)]
abstract readonly class DigitalWorkbookEvent
{
    /**
     * @param list<DigitalWorkbookEventReason> $reasons
     */
    public function __construct(
        public Uuid $uuid,
        public DigitalWorkbookEventType $type,
        #[SerializedName('date')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public DateTimeImmutable $occurredAt,
        #[SerializedName('reason')]
        public array $reasons = [],
        #[SerializedName('organization')]
        public ?DigitalWorkbookEmployer $employer = null,
        #[SerializedName('isPartTimeJob')]
        #[Context([AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public bool $isPartTime = false,
        public ?string $position = null,
        public ?string $typeName = null,
        public ?string $information = null,
        public ?string $workInFarNorth = null,
        public ?string $dataSource = null,
        #[SerializedName('cancelDate')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public ?DateTimeImmutable $cancelledAt = null,
    ) {
    }
}
