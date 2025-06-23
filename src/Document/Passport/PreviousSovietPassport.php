<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Passport;

use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class PreviousSovietPassport extends PreviousDocument
{
    public function __construct()
    {
        parent::__construct(DocumentType::SOVIET_PASSPORT);
    }
}
