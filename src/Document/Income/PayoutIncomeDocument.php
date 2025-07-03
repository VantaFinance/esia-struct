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
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;

final readonly class PayoutIncomeDocument
{
    /**
     * @param non-empty-string              $id
     * @param array<PayoutIncomeReportYear> $payoutYears
     */
    public function __construct(
        #[SerializedName('@ИдДок')]
        public string $id,
        #[SerializedName('@ДатаРожд')]
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public DateTimeImmutable $birthAt,
        #[SerializedName('@СНИЛС')]
        public SnilsNumber $snils,
        #[SerializedName('@ИННФЛ')]
        public InnNumber $innNumber,
        #[SerializedPath('[ДохСВФЛ][СведВыпл]')]
        public array $payoutYears,
    ) {
    }
}
