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
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class DigitalWorkbookLaborActivity
{
    public function __construct(
        #[SerializedName('dateBegin')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public DateTimeImmutable $startedAt,
        #[SerializedName('dateEnd')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'd.m.Y'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'],
        )]
        public DateTimeImmutable $endedAt,
        #[SerializedName('orgName')]
        public ?string $name = null,
        #[SerializedName('regNumber')]
        public ?SfrRegistrationNumber $sfrRegistrationNumber = null,
    ) {
    }
}
