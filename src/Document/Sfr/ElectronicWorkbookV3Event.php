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
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

/**
 * Документация к этим DTO: https://www.garant.ru/products/ipo/prime/doc/73352773/
 */
#[DiscriminatorDefault(ElectronicWorkbookV3UnknownEvent::class)]
#[DiscriminatorMap(
    typeProperty: 'Вид',
    /**@phpstan-ignore-next-line*/
    mapping: [
        '1' => ElectronicWorkbookV3HiringEvent::class,
        '2' => ElectronicWorkbookV3ReassignmentEvent::class,
        '3' => ElectronicWorkbookV3RenamingEvent::class,
        '4' => ElectronicWorkbookV3EstablishmentEvent::class,
        '5' => ElectronicWorkbookV3DismissalEvent::class,
        '6' => ElectronicWorkbookV3ProhibitionEvent::class,
        '7' => ElectronicWorkbookV3SuspensionEvent::class,
        '8' => ElectronicWorkbookV3ResumptionEvent::class,
    ],
)]
abstract readonly class ElectronicWorkbookV3Event
{
    public function __construct(
        #[SerializedName('UUID')]
        public Uuid $uuid,
        #[SerializedName('Вид')]
        public ElectronicWorkbookV3EventType $type,
        #[SerializedName('Работодатель')]
        public ElectronicWorkbookV3Employer $employer,
        #[SerializedName('Дата')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public DateTimeImmutable $occurredAt,
        #[SerializedName('ЯвляетсяСовместителем')]
        public bool $isPartTime = false,
        #[SerializedName('Должность')]
        public ?string $position = null,
    ) {
    }
}
