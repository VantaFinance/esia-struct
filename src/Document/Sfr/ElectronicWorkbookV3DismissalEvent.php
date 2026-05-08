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

final readonly class ElectronicWorkbookV3DismissalEvent extends ElectronicWorkbookV3Event
{
    public function __construct(
        Uuid $uuid,
        ElectronicWorkbookV3Employer $employer,
        DateTimeImmutable $occurredAt,
        #[SerializedName('Причина')]
        public ?string $reason,
        ?bool $isPartTime = false,
    ) {
        parent::__construct($uuid, ElectronicWorkbookV3EventType::DISMISSAL, $employer, $occurredAt, $isPartTime);
    }
}
