<?php

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

final readonly class InProcessLoad
{
    /**
     * @param numeric-string   $oid
     * @param non-empty-string $requestId
     */
    public function __construct(
        public string $oid,
        public string $requestId,
    ) {
    }
}
