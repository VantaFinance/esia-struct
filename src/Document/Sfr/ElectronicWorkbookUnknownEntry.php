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
use Symfony\Component\Uid\NilUuid;
use Symfony\Component\Uid\Uuid;

/**
 * @deprecated
 */
final readonly class ElectronicWorkbookUnknownEntry extends ElectronicWorkbookEntry
{
    public function __construct(
        Uuid $id = new NilUuid(),
        DateTimeImmutable $date = new DateTimeImmutable(),
        ElectronicWorkbookOrganizationInfo $organization = new ElectronicWorkbookOrganizationInfo(
            orgName: 'Имя организации',
        ),
        bool $isPartTimeJob = false,
        ?string $position = null,
    ) {
        parent::__construct(
            type: ElectronicWorkbookEntryType::UNKNOWN,
            id: $id,
            date: $date,
            organization: $organization,
            isPartTimeJob: $isPartTimeJob,
            position: $position,
        );
    }
}
