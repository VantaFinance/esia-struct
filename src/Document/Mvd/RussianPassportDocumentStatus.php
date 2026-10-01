<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Mvd;

enum RussianPassportDocumentStatus: string
{
    case VALID      = 'VALID';
    case INVALID    = 'INVALID';
    case EXPIRED    = 'EXPIRED';
    case UNVERIFIED = 'UNVERIFIED';
    case UNKNOWN    = 'UNKNOWN';

    public function isValid(): bool
    {
        return self::VALID === $this;
    }

    public static function fromPassportStatus(PassportStatus $status): self
    {
        return match ($status) {
            PassportStatus::VERIFIED_BY_VALIDATE => self::VALID,
            PassportStatus::UNVERIFIED           => self::UNVERIFIED,
        };
    }

    public static function fromPreviousRussianPassportStatus(PreviousRussianPassportStatus $status): self
    {
        return match ($status) {
            PreviousRussianPassportStatus::VALID          => self::VALID,
            PreviousRussianPassportStatus::INVALID        => self::INVALID,
            PreviousRussianPassportStatus::EXPIRED        => self::EXPIRED,
            PreviousRussianPassportStatus::NO_INFORMATION => self::UNKNOWN,
        };
    }
}
