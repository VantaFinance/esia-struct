<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Enum;

use BackedEnum;

/**
 * @template T of \BackedEnum
 *
 * @param array<T> $one
 * @param array<T> $two
 *
 * @return array<T>
 */
function array_enum_diff(array $one, array $two): array
{
    return array_udiff(
        $one,
        $two,
        static fn (BackedEnum $a, BackedEnum $b): int => strcmp((string) $a->value, (string) $b->value)
    );
}
