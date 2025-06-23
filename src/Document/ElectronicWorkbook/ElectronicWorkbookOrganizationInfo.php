<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\KppNumber;
use Vanta\Integration\Esia\Struct\Document\SfrRegistrationNumber;

final readonly class ElectronicWorkbookOrganizationInfo
{
    /**
     * @param non-empty-string $orgName
     */
    public function __construct(
        public string $orgName,
        public InnNumber $inn,
        public ?KppNumber $kpp = null,
        #[SerializedPath('[regNumber]')]
        public ?SfrRegistrationNumber $sfrRegistrationNumber = null,
    ) {
    }
}
