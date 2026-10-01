<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

use DateTimeImmutable;

/**
 * Common contract for current (RussianPassport, RussianPassportV2)
 * and previous (PreviousRussianPassport, PreviousRussianPassportV2) RF passports.
 */
interface RussianPassportDocument
{
    public function getSeries(): RussianPassportSeries;

    public function getNumber(): RussianPassportNumber;

    public function getIssuedAt(): DateTimeImmutable;

    /**
     * @return non-empty-string|null
     */
    public function getIssuedBy(): ?string;

    public function getDivisionCode(): ?RussianPassportDivisionCode;

    public function getDocumentStatus(): RussianPassportDocumentStatus;
}
