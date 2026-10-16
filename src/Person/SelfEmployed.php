<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person;

use DateTimeImmutable;

/**
 * Информация о самозанятом (вложенный объект `selfEmployed`).
 */
final readonly class SelfEmployed
{
    public function __construct(
        public bool $confirmed,
        public DateTimeImmutable $confirmDate,
    ) {
    }
}
