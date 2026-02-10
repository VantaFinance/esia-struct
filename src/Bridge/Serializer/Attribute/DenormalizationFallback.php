<?php

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class DenormalizationFallback
{
    /**
     * @param class-string $class
     */
    public function __construct(
        public string $class
    ) {
    }
}
