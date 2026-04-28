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
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\KppNumber;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class ElectronicWorkbookV2Employer
{
    public function __construct(
        #[SerializedName('ns2:НаименованиеОрганизации')]
        public string $name,
        #[SerializedName('ИНН')]
        public InnNumber $inn,
        #[SerializedName('РегНомер')]
        public ?SfrRegistrationNumber $sfrRegistrationNumber = null,
        #[SerializedName('КПП')]
        public ?KppNumber $kpp = null,
    ) {
    }
}
