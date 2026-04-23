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
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportDivisionCode;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportNumber;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportSeries;

final class RussianPassportFileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('rf_passport.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseRussianPassportFile($contents);
        $this->assertEquals((new RussianPassportSeries('4500'))->value, $output->series->value);
        $this->assertEquals((new RussianPassportNumber('799799'))->value, $output->number->value);
        $this->assertEquals((new RussianPassportDivisionCode('770100'))->value, $output->divisionCode->value);
        $this->assertEquals('07.07.2022', $output->issuedAt->format('d.m.Y'));
        $this->assertEquals('ГУ МВД России по г. Москве', $output->issuedBy);
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $this->expectException(SerializerException::class);
        $parser->parseRussianPassportFile($contents);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['rf_passport.invalid.empty.xml'];
        yield 'Bad series' => ['rf_passport.invalid.bad_series.xml'];
        yield 'Bad number' => ['rf_passport.invalid.bad_number.xml'];
        yield 'Bad issued at' => ['rf_passport.invalid.bad_issued_at.xml'];
        yield 'Bad division code' => ['rf_passport.invalid.bad_division_code.xml'];
    }
}
