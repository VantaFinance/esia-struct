<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;

final class EmailFileTest extends BaseTestCase
{
    #[DataProvider('providerValid')]
    public function testValid(): void
    {
        $contents = $this->getFixture('email.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseEmailFile($contents);
        $this->assertEquals('hello@example.com', $output->value);
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $output   = $parser->parseEmailFile($contents);
        $this->assertNull($output);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerValid(): iterable
    {
        yield 'Normal' => ['email.valid.xml'];
        yield 'Mailto' => ['email.valid_mailto.xml'];
        yield 'Whitespaces' => ['email.valid_whitespaces.xml'];
        yield 'Extracted' => ['email.valid_extracted.xml'];
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['email.invalid.empty.xml'];
        yield 'Bad value' => ['email.invalid.bad_value.xml'];
    }
}
