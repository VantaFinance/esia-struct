<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

/**
 * @deprecated
 */
final class ElectronicWorkbook extends Document
{
    /**
     * @param list<ElectronicWorkbookEntry> $events
     */
    public function __construct(
        public readonly Uuid $id,
        public readonly int $version,
        public readonly array $events = [],
        #[SerializedPath('[xmlFile][file]')]
        public readonly ?Base64DecodingReadableStream $xmlFile = null,
        #[SerializedPath('[pdfFile][file]')]
        public readonly ?Base64DecodingReadableStream $pdfFile = null,
    ) {
        parent::__construct(DocumentType::ELECTRONIC_WORKBOOK);
    }
}
