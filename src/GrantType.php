<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

enum GrantType: string
{
    /**
     * Получение маркер доступа с помощью refresh token
     */
    case REFRESH_TOKEN = 'refresh_token';

    /**
     * Получение маркер доступа с помощью авторизационого кода
     */
    case AUTHORIZATION_CODE = 'authorization_code';

    /**
     * Получение маркера доступа(доступен со scope: prm_chg?oid={oid})
     */
    case CLIENT_CREDENTIALS = 'client_credentials';
}
