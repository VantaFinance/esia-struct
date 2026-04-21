<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;

final class FullNameFileTest extends BaseTestCase
{
    /**
     * @param array{non-empty-string, non-empty-string, non-empty-string|null} $expected
     *
     * @throws SerializerException
     */
    #[DataProvider('providerValid')]
    public function testValid(string $filename, array $expected): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $output   = $parser->parseFullNameFile($contents);
        $this->assertEquals($expected[0], $output->lastName);
        $this->assertEquals($expected[1], $output->firstName);
        $this->assertEquals($expected[2], $output->middleName);
    }

    /**
     * @return iterable<array{non-empty-string, array{non-empty-string, non-empty-string, non-empty-string|null}}>
     */
    public static function providerValid(): iterable
    {
        yield 'First Last Middle' => ['full_name.valid.xml', ['Башмачкин', 'Акакий', 'Акакиевич']];
        yield 'First Last' => ['full_name.valid.without_middle_name.xml', ['Башмачкин', 'Акакий', null]];
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $this->expectException(SerializerException::class);
        $parser->parseFullNameFile($contents);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['full_name.invalid.empty.xml'];
        yield 'Missing first name' => ['full_name.invalid.missing_first_name.xml'];
        yield 'Missing last name' => ['full_name.invalid.missing_last_name.xml'];
    }
}
