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
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

#[DiscriminatorDefault(WorkbookUnknownEvent::class)]
#[DiscriminatorMap(
    typeProperty: 'ns2:Вид',
    /**@phpstan-ignore-next-line*/
    mapping: [
        '1' => WorkbookHiringEvent::class,
        '2' => WorkbookReassignmentEvent::class,
        '5' => WorkbookDismissalEvent::class,
    ],
)]
abstract readonly class WorkbookEvent
{
    public function __construct(
        #[SerializedName('ns2:Вид')]
        public WorkbookEventType $type,
        #[SerializedName('ns2:Работодатель')]
        public WorkbookEmployer $employer,
        #[SerializedName('ns2:Дата')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public DateTimeImmutable $occurredAt,
        #[SerializedName('ns2:ЯвляетсяСовместителем')]
        public ?bool $isPartTime = false,
    ) {
    }
}
