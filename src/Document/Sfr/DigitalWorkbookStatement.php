<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final readonly class DigitalWorkbookStatement
{
    public function __construct(
        #[SerializedName('continuationDate')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public ?DateTimeImmutable $continuedAt = null,
        #[SerializedName('provisionDate')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public ?DateTimeImmutable $providedAt = null,
    ) {
    }
}
