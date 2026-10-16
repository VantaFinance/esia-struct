<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Grant;

use ArrayIterator;
use Countable;
use IteratorAggregate;

/**
 * Согласия, выданные пользователем (REST API ЕСИА `prns/{oid}/issued/permissions`, массив `elements`). Пустой список — допустимый ответ.
 *
 * @implements IteratorAggregate<int, GrantedPermission>
 */
final readonly class GrantedPermissions implements IteratorAggregate, Countable
{
    /**
     * @param list<GrantedPermission> $permissions
     */
    public function __construct(
        private array $permissions = [],
    ) {
    }

    /**
     * @return list<GrantedPermission>
     */
    public function toArray(): array
    {
        return $this->permissions;
    }

    /**
     * @return ArrayIterator<int, GrantedPermission>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->permissions);
    }

    public function count(): int
    {
        return \count($this->permissions);
    }
}
