<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Uid\Uuid;

final readonly class ElectronicWorkbookUnknownEntry extends ElectronicWorkbookEntry
{
    public function __construct(
        #[SerializedName('uuid')]
        public Uuid $id,
    ) {
        parent::__construct(ElectronicWorkbookEntryType::UNKNOWN);
    }
}
