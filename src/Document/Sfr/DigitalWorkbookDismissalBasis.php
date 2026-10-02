<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

final readonly class DigitalWorkbookDismissalBasis
{
    public function __construct(
        public ?string $type = null,
        public ?string $normativeDocument = null,
        public ?string $basisItem = null,
        public ?string $basisPart = null,
        public ?string $basisParagraph = null,
        public ?string $basisSubparagraph = null,
        public ?string $paragraph = null,
    ) {
    }
}
