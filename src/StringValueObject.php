<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

use InvalidArgumentException;
use Stringable;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\StringValueObjectNormalizer;

/**
 * Значение ЕСИА из одной строки (СНИЛС, ИНН, серия паспорта и т. п.), проверяемое при создании.
 *
 * Реализации разбирает {@see StringValueObjectNormalizer} без перечисления классов: новому значению
 * достаточно реализовать этот интерфейс.
 */
interface StringValueObject extends Stringable
{
    /**
     * @throws InvalidArgumentException если формат не совпадает; новые реализации не должны включать
     *                                  значение в сообщение (это персональные данные)
     */
    public function __construct(string $value);
}
