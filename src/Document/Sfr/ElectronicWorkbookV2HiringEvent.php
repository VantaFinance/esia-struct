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
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

final readonly class ElectronicWorkbookV2HiringEvent extends ElectronicWorkbookV2Event
{
    public function __construct(
        Uuid $uuid,
        ElectronicWorkbookV2Employer $employer,
        DateTimeImmutable $occurredAt,
        #[SerializedName('ns2:Должность')]
        public ?string $position = null,
        ?bool $isPartTime = false,
    ) {
        parent::__construct($uuid, ElectronicWorkbookV2EventType::HIRING, $employer, $occurredAt, $isPartTime);
    }
}
