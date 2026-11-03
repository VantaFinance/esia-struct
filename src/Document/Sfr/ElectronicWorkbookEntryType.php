<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

/**
 * @deprecated
 */
enum ElectronicWorkbookEntryType: string
{
    case HIRING        = 'HIRING';        // Прием
    case REASSIGNMENT  = 'REASSIGNMENT';  // Перевод
    case RENAMING      = 'RENAMING';      // Переименование
    case ESTABLISHMENT = 'ESTABLISHMENT'; // Установление (Присвоение)
    case DISMISSAL     = 'DISMISSAL';     // Увольнение
    case PROHIBITION   = 'PROHIBITION';   // Запрет занимать должность (Вид деятельности)
    case SUSPENSION    = 'SUSPENSION';    // Приостановление
    case RESUMPTION    = 'RESUMPTION';    // Возобновление
    case UNKNOWN       = 'UNKNOWN';
}
