<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Grant;

use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Vanta\Integration\Esia\Struct\Permission;

/**
 * Разрешение (scope), входящее в согласие.
 */
final readonly class GrantedScope
{
    /**
     * @param Permission            $sysname     значение каталога; {@see Permission::UNKNOWN}, если его нет в каталоге
     * @param string                $rawSysname  мнемоника, как её прислала ЕСИА
     * @param non-empty-string|null $name
     * @param non-empty-string|null $description
     * @param non-empty-string|null $orgGroup
     */
    public function __construct(
        #[SerializedPath('[sysname]')]
        public Permission $sysname,
        #[SerializedName('sysname')]
        public string $rawSysname,
        public ?string $name = null,
        public ?string $description = null,
        public ?string $orgGroup = null,
    ) {
    }
}
