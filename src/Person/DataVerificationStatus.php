<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person;

/**
 * Статус верификации контакта / документа (поле `vrfStu`).
 */
enum DataVerificationStatus: string
{
    case VERIFIED     = 'VERIFIED';
    case NOT_VERIFIED = 'NOT_VERIFIED';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
