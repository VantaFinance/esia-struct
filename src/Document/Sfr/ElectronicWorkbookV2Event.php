<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

#[DiscriminatorDefault(ElectronicWorkbookV2UnknownEvent::class)]
#[DiscriminatorMap(
    typeProperty: 'ns2:Вид',
    /**@phpstan-ignore-next-line*/
    mapping: [
        '1' => ElectronicWorkbookV2HiringEvent::class,
        '2' => ElectronicWorkbookV2ReassignmentEvent::class,
        '5' => ElectronicWorkbookV2DismissalEvent::class,
    ],
)]
abstract readonly class ElectronicWorkbookV2Event
{
    public function __construct(
        #[SerializedPath('[ns2:UUID]')]
        public Uuid $uuid,
        #[SerializedName('ns2:Вид')]
        public ElectronicWorkbookV2EventType $type,
        #[SerializedName('ns2:Работодатель')]
        public ElectronicWorkbookV2Employer $employer,
        #[SerializedName('ns2:Дата')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public DateTimeImmutable $occurredAt,
        #[SerializedName('ns2:ЯвляетсяСовместителем')]
        public ?bool $isPartTime = false,
    ) {
    }
}
