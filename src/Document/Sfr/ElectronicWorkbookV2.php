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
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

/**
 * @deprecated
 */
final class ElectronicWorkbookV2 extends Document
{
    /**
     * @param list<ElectronicWorkbookV2Event>                  $events
     * @param list<ElectronicWorkbookV2EmploymentHistoryEntry> $history
     */
    public function __construct(
        #[SerializedPath('[ns2:СТД-ПФР][ns2:ЗЛ]')]
        public readonly Person $person,
        #[SerializedPath('[ns2:СТД-ПФР][ns2:Мероприятие]')]
        public readonly array $events = [],
        #[SerializedPath('[ns2:СТД-ПФР][ns2:ТрудоваяДеятельность][ns2:ПериодРаботы]')]
        public readonly array $history = [],
    ) {
        parent::__construct(DocumentType::ELECTRONIC_WORKBOOK_V2);
    }
}
