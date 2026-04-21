<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;

final readonly class WorkbookUnknownEvent extends WorkbookEvent
{
    public function __construct(
        WorkbookEmployer $employer,
        DateTimeImmutable $occurredAt,
        ?bool $isPartTime = false,
    ) {
        parent::__construct(WorkbookEventType::UNKNOWN, $employer, $occurredAt, $isPartTime);
    }
}
