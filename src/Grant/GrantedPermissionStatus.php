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
 * Статус согласия.
 */
enum GrantedPermissionStatus: string
{
    /**
     * Действует
     */
    case ACTIVE = 'A';

    /**
     * Удалено
     */
    case DELETED = 'D';

    /**
     * Не действует
     */
    case INACTIVE = 'I';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
