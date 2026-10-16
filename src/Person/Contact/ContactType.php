<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Contact;

/**
 * Тип контакта (поле `type` элемента `contacts`).
 */
enum ContactType: string
{
    /**
     * Мобильный телефон
     */
    case MOBILE = 'MBT';

    /**
     * Электронная почта
     */
    case EMAIL = 'EML';

    /**
     * Домашний телефон
     */
    case PHONE = 'PHN';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
