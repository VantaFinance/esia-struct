<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

/**
 * @deprecated
 */
final readonly class ElectronicWorkbookDismissalEntry extends ElectronicWorkbookEntry
{
    public function __construct(
        Uuid $id,
        DateTimeImmutable $date,
        ElectronicWorkbookOrganizationInfo $organization,
        bool $isPartTimeJob = false,
        ?string $position = null,
    ) {
        parent::__construct(
            type: ElectronicWorkbookEntryType::DISMISSAL,
            id: $id,
            date: $date,
            organization: $organization,
            isPartTimeJob: $isPartTimeJob,
            position: $position,
        );
    }
}
