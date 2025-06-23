<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

/**
 * Типы авторизации
 */
enum PersonFilter: string
{
    /**
     * Авторизация только подтвержденных учетных записей
     */
    case CONF_ACC = 'conf_acc';

    /**
     * Авторизация только учетных записей детей
     */
    case ACC_KID = 'acc_kid';

    /**
     * Авторизация всех учетных записей, кроме учетных записей детей
     */
    case ACC_NOT_KID = 'acc_not_kid';
}
