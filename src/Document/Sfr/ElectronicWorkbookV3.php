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

final readonly class ElectronicWorkbookV3 extends Document
{
    /**
     * @param list<ElectronicWorkbookV3Event>                  $events
     * @param list<ElectronicWorkbookV3EmploymentHistoryEntry> $history
     */
    public function __construct(
        #[SerializedPath('[СТД-СФР][ЗЛ]')]
        public PersonV2 $person,
        #[SerializedPath('[СТД-СФР][Мероприятие]')]
        public array $events = [],
        #[SerializedPath('[СТД-СФР][ТрудоваяДеятельность][ПериодРаботы]')]
        public array $history = [],
    ) {
        parent::__construct(DocumentType::ELECTRONIC_WORKBOOK_V3);
    }
}
