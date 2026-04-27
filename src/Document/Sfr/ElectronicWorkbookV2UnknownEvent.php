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

final readonly class ElectronicWorkbookV2UnknownEvent extends ElectronicWorkbookV2Event
{
    public function __construct(
        ElectronicWorkbookV2Employer $employer,
        DateTimeImmutable $occurredAt,
        ?bool $isPartTime = false,
    ) {
        parent::__construct(ElectronicWorkbookV2EventType::UNKNOWN, $employer, $occurredAt, $isPartTime);
    }
}
