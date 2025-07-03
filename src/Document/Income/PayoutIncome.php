<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Uid\Uuid;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class PayoutIncome extends Document
{
    /**
     * @param numeric-string   $oid
     * @param positive-int     $version
     * @param non-empty-string $departmentDoc
     * @param non-empty-string $relevance
     * @param non-empty-string $status
     */
    public function __construct(
        public string $oid,
        public Uuid $id,
        public int $version,
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
        public string $departmentDoc,
        public string $relevance,
        public string $status,
        #[SerializedPath('[content][xmlFile]')]
        public PayoutIncomeBase64File $xmlFile,
        #[SerializedPath('[content][pdfFile]')]
        public ?PayoutIncomeBase64File $pdfFile = null
    ) {
        parent::__construct(DocumentType::PAYOUT_INCOME);
    }
}
