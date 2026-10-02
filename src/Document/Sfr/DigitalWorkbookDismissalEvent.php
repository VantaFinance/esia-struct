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
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

final readonly class DigitalWorkbookDismissalEvent extends DigitalWorkbookEvent
{
    /**
     * @param list<DigitalWorkbookEventReason> $reasons
     */
    public function __construct(
        Uuid $uuid,
        DateTimeImmutable $occurredAt,
        array $reasons = [],
        ?DigitalWorkbookEmployer $employer = null,
        bool $isPartTime = false,
        ?string $position = null,
        ?string $typeName = null,
        ?string $information = null,
        ?string $workInFarNorth = null,
        ?string $dataSource = null,
        ?DateTimeImmutable $cancelledAt = null,
        public ?DigitalWorkbookDismissalBasis $dismissalBasis = null,
        #[SerializedName('dismissalReason')]
        public ?string $reason = null,
    ) {
        parent::__construct(
            uuid: $uuid,
            type: DigitalWorkbookEventType::DISMISSAL,
            occurredAt: $occurredAt,
            reasons: $reasons,
            employer: $employer,
            isPartTime: $isPartTime,
            position: $position,
            typeName: $typeName,
            information: $information,
            workInFarNorth: $workInFarNorth,
            dataSource: $dataSource,
            cancelledAt: $cancelledAt,
        );
    }
}
