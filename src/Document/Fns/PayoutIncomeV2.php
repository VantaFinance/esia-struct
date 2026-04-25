<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Fns;

use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer as ObjectNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

/**
 * Описание структуры
 *
 * @see https://lkuv.gosuslugi.ru/paip-portal/#/inquiries/card/6377e305-ff80-11eb-ba23-33408f10c8dc?2%5Btab%5D=PROD&tab=2
 */
final readonly class PayoutIncomeV2 extends Document
{
    /**
     * @param non-empty-string $id
     * @param non-empty-string $versionForm
     */
    public function __construct(
        #[SerializedName('@ИдФайл')]
        public string $id,
        #[SerializedName('@ВерсФорм')]
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public string $versionForm,
        #[SerializedName('@КолДок')]
        public int $countDocuments,
        #[SerializedName('Документ')]
        public PayoutIncomeDocument $document,
    ) {
        parent::__construct(DocumentType::PAYOUT_INCOME_V2);
    }
}
