<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

enum ElectronicWorkbookV3EventType: string
{
    case HIRING                 = '1';  // Прием
    case REASSIGNMENT           = '2';  // Перевод
    case RENAMING               = '3';  // Переименование
    case ESTABLISHMENT          = '4';  // Установление (Присвоение)
    case DISMISSAL              = '5';  // Увольнение
    case PROHIBITION            = '6';  // Запрет занимать должность (Вид деятельности)
    case SUSPENSION             = '7';  // Приостановление
    case RESUMPTION             = '8';  // Возобновление
    case MILITARY_SERVICE       = '11'; // Служба в армии
    case EDUCATION              = '12'; // Образование
    case TRAINING               = '13'; // Обучение
    case AWARD                  = '14'; // Награждение (Поощрение)
    case CONTINUOUS_EXCLUSION   = '15'; // Исключение из непрерывного стажа
    case CONTINUOUS_RESTORATION = '16'; // Восстановление непрерывного стажа
    case CORRECTION             = '17'; // Исправление / удаление / восстановление / аннулирование
    case UNKNOWN                = '_';
}
