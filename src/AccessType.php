<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

enum AccessType: string
{
    /**
     * Выпускает маркер доступа(access_token)
     */
    case ONLINE = 'online';

    /**
     * Выпускает маркер доступа(access_token) и маркер обновления(refresh_token)
     */
    case OFFLINE = 'offline';
}
