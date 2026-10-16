<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Grant;

/**
 * Статус подписания согласия.
 */
enum SignatureStatus: string
{
    case ISSUED  = 'ISSUED';
    case PENDING = 'PENDING';
    case FAILED  = 'FAILED';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
