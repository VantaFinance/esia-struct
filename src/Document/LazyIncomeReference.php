<?php

/**
 * ESIA Struct
 *
 * @author    Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */


declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

use Brick\DateTime\Year;

final readonly class LazyIncomeReference
{
    /**
     * @param numeric-string   $oid
     * @param non-empty-string $requestId
     */
    public function __construct(
        public string $oid,
        public string $requestId,
        public DocumentType $type,
        public Year $year,
    ) {
    }
}
