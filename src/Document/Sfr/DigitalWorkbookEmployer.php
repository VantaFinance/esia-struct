<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\KppNumber;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class DigitalWorkbookEmployer
{
    public function __construct(
        #[SerializedName('orgName')]
        public ?string $name = null,
        public ?InnNumber $inn = null,
        #[SerializedName('regNumber')]
        public ?SfrRegistrationNumber $sfrRegistrationNumber = null,
        public ?KppNumber $kpp = null,
    ) {
    }
}
