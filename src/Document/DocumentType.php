<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

enum DocumentType: string
{
    case UNKNOWN                        = 'UNKNOWN';
    case RUSSIAN_INTERNATIONAL_PASSPORT = 'FRGN_PASS';
    case RUSSIAN_PASSPORT               = 'RF_PASSPORT';
    case PAYOUT_INCOME                  = 'PAYOUT_INCOME';
    case SOVIET_PASSPORT                = 'USSR_PASSPORT';
    case PASSPORT_HISTORY               = 'PASSPORT_HISTORY';
    case INCOME_REFERENCE               = 'INCOME_REFERENCE';
    case RUSSIAN_DRIVER_LICENSE         = 'RF_DRIVING_LICENSE';
    case ELECTRONIC_WORKBOOK            = 'ELECTRONIC_WORKBOOK';
}
