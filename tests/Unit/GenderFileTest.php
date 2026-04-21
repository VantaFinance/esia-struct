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
use Vanta\Integration\Esia\Struct\Gender;

final class GenderFileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     */
    #[DataProvider('providerValid')]
    public function testValid(string $filename, Gender $expected): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $output   = $parser->parseGenderFile($contents);
        $this->assertEquals($expected, $output->gender);
    }

    /**
     * @return iterable<array{non-empty-string, Gender}>
     */
    public static function providerValid(): iterable
    {
        yield 'Male' => ['gender.valid.male.xml', Gender::MALE];
        yield 'Female' => ['gender.valid.female.xml', Gender::FEMALE];
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $this->expectException(SerializerException::class);
        $parser->parseGenderFile($contents);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['gender.invalid.empty.xml'];
        yield 'Bad value' => ['gender.invalid.bad_value.xml'];
    }
}
