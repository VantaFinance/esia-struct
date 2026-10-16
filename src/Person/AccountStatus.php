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
 * Статус учётной записи (поле `status`).
 */
enum AccountStatus: string
{
    case REGISTERED = 'REGISTERED';
    case DELETED    = 'DELETED';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
