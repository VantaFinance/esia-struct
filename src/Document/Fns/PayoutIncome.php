<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Fns;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final class PayoutIncome extends Document
{
    /**
     * @param numeric-string        $oid
     * @param positive-int          $version
     * @param non-empty-string|null $departmentDoc
     * @param non-empty-string      $relevance
     * @param non-empty-string      $status
     */
    public function __construct(
        public readonly string $oid,
        public readonly Uuid $id,
        public readonly int $version,
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
        public readonly string $relevance,
        public readonly string $status,
        #[SerializedPath('[content][xmlFile]')]
        public readonly PayoutIncomeBase64File $xmlFile,
        #[SerializedPath('[content][pdfFile]')]
        public readonly ?PayoutIncomeBase64File $pdfFile = null,
        public readonly ?string $departmentDoc = null,
    ) {
        parent::__construct(DocumentType::PAYOUT_INCOME);
    }
}
