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
use Symfony\Component\Uid\NilUuid;

final readonly class ElectronicWorkbookV3UnknownEvent extends ElectronicWorkbookV3Event
{
    public function __construct(
        ElectronicWorkbookV3Employer $employer,
        DateTimeImmutable $occurredAt,
        ?bool $isPartTime = false,
    ) {
        parent::__construct(new NilUuid(), ElectronicWorkbookV3EventType::UNKNOWN, $employer, $occurredAt, $isPartTime);
    }
}
