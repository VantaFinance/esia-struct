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


/**
 * Описание структуры
 *
 * @link https://lkuv.gosuslugi.ru/paip-portal/#/inquiries/card/6377e305-ff80-11eb-ba23-33408f10c8dc?2%5Btab%5D=PROD&tab=2
 */
final readonly class PayoutIncomeFile
{
    /**
     * @param non-empty-string            $id
     * @param non-empty-string            $versionForm
     */
    public function __construct(
        #[SerializedName('@ИдФайл')]
        public string $id,
        #[SerializedName('@ВерсФорм')]
        public string $versionForm,
        #[SerializedName('@КолДок')]
        public int $countDocuments,
        #[SerializedName('Документ')]
        public PayoutIncomeDocument $document,
    ) {
    }
}
