<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

use Symfony\Component\Serializer\Annotation as Serializer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\UnknownPreviousDocument;

#[DiscriminatorDefault(UnknownPreviousDocument::class)]
#[Serializer\DiscriminatorMap(
    typeProperty: 'ns2:passportType',
    mapping: [
        DocumentType::RUSSIAN_PASSPORT->value               => PreviousRussianPassportV2::class,
        DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT->value => PreviousRussianInternationalPassportV2::class,
        DocumentType::SOVIET_PASSPORT->value                => PreviousSovietPassport::class,
    ],
)]
abstract readonly class PreviousDocumentV2 extends PreviousDocument
{
    #[Serializer\SerializedPath('[ns2:passportType]')]
    public DocumentType $type;

    public function __construct(DocumentType $type)
    {
        $this->type = $type;
    }
}
