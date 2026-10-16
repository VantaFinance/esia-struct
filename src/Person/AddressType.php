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
 * Тип адреса (поле `type` элемента `addresses`). Значения по методике ЕСИА.
 */
enum AddressType: string
{
    /**
     * Адрес места проживания / жительства / пребывания
     */
    case PLACE_OF_LIVING = 'PLV';

    /**
     * Адрес временной регистрации / постановки на учёт по месту пребывания
     */
    case TEMPORARY_ADDRESS = 'PTA';

    /**
     * Адрес постоянной регистрации / места жительства
     */
    case PERMANENT_ADDRESS = 'PRG';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
