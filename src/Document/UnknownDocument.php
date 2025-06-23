<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

final readonly class UnknownDocument extends Document
{
    public function __construct()
    {
        parent::__construct(DocumentType::UNKNOWN);
    }
}
