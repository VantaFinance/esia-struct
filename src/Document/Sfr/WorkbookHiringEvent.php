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

final readonly class WorkbookHiringEvent extends WorkbookEvent
{
    public function __construct(
        WorkbookEventType $type,
        WorkbookEmployer $employer,
        DateTimeImmutable $occurredAt,
        #[SerializedName('ns2:Должность')]
        public ?string $position = null,
        ?bool $isPartTime = false,
    ) {
        parent::__construct($type, $employer, $occurredAt, $isPartTime);
    }
}
