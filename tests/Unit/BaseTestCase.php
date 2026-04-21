<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getFixture(string $filename): string
    {
        $content = file_get_contents(__DIR__ . '/../fixtures/' . $filename);

        if (false === $content) {
            throw new InvalidArgumentException("Fixture $filename not found.");
        }

        return $content;
    }
}
