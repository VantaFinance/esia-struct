<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PayoutFile
{
    /**
     * @param non-empty-string            $id
     * @param non-empty-string            $versionForm
     * @param array<PayoutIncomeDocument> $files
     */
    public function __construct(
        #[SerializedName('@ИдФайл')]
        public string $id,
        #[SerializedName('@ВерсФорм')]
        public string $versionForm,
        #[SerializedName('@КолДок')]
        public int $countDocuments,
        #[SerializedName('Документ')]
        public array $files = []
    ) {
    }
}
