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
use Vanta\Integration\Esia\Struct\Action;

/**
 * Действие над данными, разрешённое согласием.
 */
final readonly class GrantedAction
{
    /**
     * @param Action                $sysname    значение каталога; {@see Action::UNKNOWN}, если его нет в каталоге
     * @param string                $rawSysname мнемоника, как её прислала ЕСИА
     * @param non-empty-string|null $name
     */
    public function __construct(
        #[SerializedPath('[sysname]')]
        public Action $sysname,
        #[SerializedName('sysname')]
        public string $rawSysname,
        public ?string $name = null,
    ) {
    }
}
