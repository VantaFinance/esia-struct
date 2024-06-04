<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

final readonly class IncomeReferenceBase64File
{
    /**
     * @param non-empty-string $name
     * @param non-empty-string $metadata
     */
    public function __construct(
        public string $name,
        public string $metadata,
        #[SerializedName('createdOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public DateTimeImmutable $createdAt,
        #[SerializedName('updatedOn')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => 'U.n'])]
        public DateTimeImmutable $updatedAt,
        #[SerializedName('file')]
        public Base64DecodingReadableStream $content,
        #[SerializedName('sign')]
        public Base64DecodingReadableStream $sign,
    ) {
    }
}
