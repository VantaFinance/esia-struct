<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class WorkbookFile
{
    /**
     * @param list<WorkbookEvent>                  $events
     * @param list<WorkbookEmploymentHistoryEntry> $history
     */
    public function __construct(
        #[SerializedPath('[ns2:СТД-ПФР][ns2:ЗЛ]')]
        public WorkbookPerson $person,
        #[SerializedPath('[ns2:СТД-ПФР][ns2:Мероприятие]')]
        public array $events,
        #[SerializedPath('[ns2:СТД-ПФР][ns2:ТрудоваяДеятельность][ns2:ПериодРаботы]')]
        public array $history,
    ) {
    }
}
