<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook;

use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class ElectronicWorkbook extends Document
{
    /**
     * @param list<ElectronicWorkbookEntry> $events
     */
    public function __construct(
        public ?Uuid $id,
        public int $version,
        public array $events,
    ) {
        parent::__construct(DocumentType::ELECTRONIC_WORKBOOK);
    }
}
