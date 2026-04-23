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
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;

final class InnFileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('inn.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseInnFile($contents);
        $this->assertEquals('123456789012', $output->inn->value);
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $this->expectException(SerializerException::class);
        $parser->parseInnFile($contents);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['inn.invalid.empty.xml'];
        yield 'Bad value' => ['inn.invalid.bad_value.xml'];
    }
}
