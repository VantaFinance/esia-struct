<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class ElectronicWorkbook extends Document
{
    /**
     * @param list<ElectronicWorkbookEntry> $events
     */
    public function __construct(
        public Uuid $id,
        public int $version,
        public array $events = [],
        #[SerializedPath('[xmlFile][file]')]
        public ?Base64DecodingReadableStream $xmlFile = null,
        #[SerializedPath('[pdfFile][file]')]
        public ?Base64DecodingReadableStream $pdfFile = null,
    ) {
        parent::__construct(DocumentType::ELECTRONIC_WORKBOOK);
    }
}
