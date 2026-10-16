<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;

/**
 * @deprecated
 */
final class IndividualInsuranceAccountStatement extends Document
{
    /**
     * @param non-empty-string       $lastName
     * @param non-empty-string       $firstName
     * @param non-empty-string|null  $middleName
     * @param array<PreviousIpkYear> $previousIpkYears
     */
    public function __construct(
        #[SerializedName('createdOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly DateTimeImmutable $createAt,
        #[SerializedName('updatedOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly DateTimeImmutable $updatedAt,
        #[SerializedName('validateDateDoc')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly DateTimeImmutable $validateAt,
        #[SerializedName('receiptDocDate')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public readonly DateTimeImmutable $receiptAt,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public readonly DateTimeImmutable $birthDate,
        public readonly string $lastName,
        public readonly string $firstName,
        public readonly SnilsNumber $snils,
        public readonly float $ipk,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public readonly DateTimeImmutable $requestDate,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public readonly DateTimeImmutable $formationDate,
        public readonly ?IpkYear $ipkCurrentYear = null,
        #[SerializedName('ipkSince2015')]
        public readonly array $previousIpkYears = [],
        public readonly ?string $middleName = null,
    ) {
        parent::__construct(DocumentType::ILS_PFR);
    }
}
