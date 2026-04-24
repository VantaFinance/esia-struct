<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use Brick\PhoneNumber\PhoneNumberFormat;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;

final class MobilePhoneFileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('mobile_phone.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseMobilePhoneFile($contents);
        $this->assertEquals('+79991234567', $output->phoneNumber->format(PhoneNumberFormat::E164));
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $this->expectException(SerializerException::class);
        $parser->parseMobilePhoneFile($contents);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['mobile_phone.invalid.empty.xml'];
        yield 'Bad value' => ['mobile_phone.invalid.bad_value.xml'];
    }
}
