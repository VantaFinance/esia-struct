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
 * Статус процесса подтверждения контакта или документа (поле `vrfValStu`); есть, только пока объект проверяется.
 */
enum VerifyingStatus: string
{
    /**
     * В процессе подтверждения
     */
    case VERIFYING = 'VERIFYING';

    /**
     * Ошибка проверки (только для документов)
     */
    case VERIFICATION_FAILED = 'VERIFICATION_FAILED';

    /**
     * Значение, которого нет в каталоге: только в ответах ЕСИА
     */
    case UNKNOWN = 'UNKNOWN';
}
