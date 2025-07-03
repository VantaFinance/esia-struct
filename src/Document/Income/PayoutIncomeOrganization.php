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
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\KppNumber;

final readonly class PayoutIncomeOrganization
{
    public function __construct(
        #[SerializedName('@НаимОрг')]
        public string $name,
        #[SerializedName('@ИННЮЛ')]
        public InnNumber $inn,
        #[SerializedName('@КПП')]
        public KppNumber $kpp,
    ) {
    }
}
