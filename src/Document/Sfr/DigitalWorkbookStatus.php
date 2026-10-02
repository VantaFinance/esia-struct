<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

enum DigitalWorkbookStatus: string
{
    case SUCCESS                = 'SUCCESS';                // Данные из витрины получены успешно
    case SEARCH                 = 'SEARCH';                 // Выполняется запрос в витрину
    case NO_RUSSIAN_CITIZENSHIP = 'NO_RUSSIAN_CITIZENSHIP'; // Пользователь не гражданин РФ
    case NO_CONSENT             = 'NO_CONSENT';             // Не выдано генеральное согласие для Минцифры России
    case NO_PERMISSIONS         = 'NO_PERMISSIONS';         // Неподтвержденная УЗ пользователя ЕПГУ
    case NO_DATA                = 'NO_DATA';                // Не найдены данные по указанному пользователю в витрине
    case REQUEST_FAILED         = 'REQUEST_FAILED';         // Получена ошибка при запросе сведений из витрины
}
