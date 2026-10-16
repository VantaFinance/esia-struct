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
use Vanta\Integration\Esia\Struct\Sysname;

/**
 * Цель обработки, указанная в согласии.
 */
final readonly class GrantedPurpose
{
    /**
     * @param Sysname               $sysname    значение каталога; {@see Sysname::UNKNOWN}, если его нет в каталоге
     * @param string                $rawSysname мнемоника, как её прислала ЕСИА
     * @param non-empty-string|null $name
     */
    public function __construct(
        #[SerializedPath('[sysname]')]
        public Sysname $sysname,
        #[SerializedName('sysname')]
        public string $rawSysname,
        public ?string $name = null,
    ) {
    }
}
