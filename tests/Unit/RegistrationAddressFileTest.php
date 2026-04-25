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

final class RegistrationAddressFileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('registration_address.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseRegistrationAddressFile($contents);
        $this->assertEquals('г. Москва, ул. Пушкина', $output->addressStr);
        $this->assertEquals('RUS', $output->countryIso->value);
        $this->assertEquals('123100', $output->zipCode);
        $this->assertEquals('Москва', $output->region);
        $this->assertEquals('Пушкина', $output->street);
        $this->assertEquals('1', $output->house);
        $this->assertEquals('9', $output->flat);
        $this->assertEquals('3c11bfb6-d439-490d-8185-14494ffbb677', $output->fiasCode->toRfc4122());
    }

    #[DataProvider('providerInvalid')]
    public function testInvalid(string $filename): void
    {
        $contents = $this->getFixture($filename);
        $parser   = DocumentParser::create();
        $this->expectException(SerializerException::class);
        $parser->parseRegistrationAddressFile($contents);
    }

    /**
     * @return iterable<array{non-empty-string}>
     */
    public static function providerInvalid(): iterable
    {
        yield 'Empty' => ['registration_address.invalid.empty.xml'];
    }
}
