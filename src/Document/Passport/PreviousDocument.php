<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Passport;

use Symfony\Component\Serializer\Annotation as Serializer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\UnknownPreviousDocument;

#[DiscriminatorDefault(UnknownPreviousDocument::class)]
#[Serializer\DiscriminatorMap(
    typeProperty: 'passportType',
    mapping: [
        'rf_passport'   => PreviousRussianPassport::class,
        'frgn_pass'     => PreviousRussianInternationalPassport::class,
        'ussr_passport' => PreviousSovietPassport::class,
    ],
)]
abstract readonly class PreviousDocument extends Document
{
    #[Serializer\SerializedPath('[passportType]')]
    public DocumentType $type;

    public function __construct(DocumentType $type)
    {
        $this->type = $type;
    }
}
