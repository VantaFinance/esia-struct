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

final readonly class ElectronicWorkbookV3Employer
{
    public function __construct(
        #[SerializedName('НаименованиеОрганизации')]
        public string $name,
        #[SerializedName('УТ6:ИНН')]
        public InnNumber $inn,
        #[SerializedName('УТ6:РегНомер')]
        public ?SfrRegistrationNumber $sfrRegistrationNumber = null,
        #[SerializedName('КПП')]
        public ?KppNumber $kpp = null,
    ) {
    }
}
