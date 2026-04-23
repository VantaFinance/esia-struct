<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PensionWorkTimeRecord
{
    public function __construct(
        #[SerializedName('ns3:ВсеГоды')]
        public int $years,
        #[SerializedName('ns3:ВсеМесяцы')]
        public int $months,
        #[SerializedName('ns3:ВсеДни')]
        public int $days,
    ) {
    }
}
