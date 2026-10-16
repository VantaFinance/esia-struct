<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Document;

use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

/**
 * Документ пользователя (элемент `documents`). Документ неизвестного типа или не прошедший проверку
 * разбирается в {@see UnknownPersonDocument}.
 */
#[DiscriminatorDefault(UnknownPersonDocument::class)]
#[DiscriminatorMap('type', [
    'RF_PASSPORT' => PersonRussianPassport::class,
])]
abstract readonly class PersonDocument
{
    public function __construct(
        public DocumentType $type,
    ) {
    }
}
