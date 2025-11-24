<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class IndividualInsuranceAccountStatementRaw extends Document
{
    /**
     * @param non-empty-string      $lastName
     * @param non-empty-string      $firstName
     * @param non-empty-string|null $middleName
     */
    public function __construct(
        #[SerializedName('createdOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public DateTimeImmutable $createAt,
        #[SerializedName('updatedOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public DateTimeImmutable $updatedAt,
        #[SerializedName('validateDateDoc')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public DateTimeImmutable $validateAt,
        #[SerializedName('receiptDocDate')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public DateTimeImmutable $receiptAt,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public DateTimeImmutable $birthDate,
        public string $lastName,
        public string $firstName,
        public Base64DecodingReadableStream $content,
        public ?string $middleName = null,
    ) {
        parent::__construct(DocumentType::ILS_PFR);
    }
}
