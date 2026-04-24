<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Document;

use Vanta\Integration\Esia\Struct\Document\Base\EmailFile;
use Vanta\Integration\Esia\Struct\Document\Base\HomeAddressFile;
use Vanta\Integration\Esia\Struct\Document\Base\MobilePhoneFile;
use Vanta\Integration\Esia\Struct\Document\Base\RegistrationAddressFile;
use function Amp\ByteStream\buffer;

use Amp\ByteStream\BufferException;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;
use Symfony\Component\Serializer\SerializerInterface as Serializer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\Base64DecodingReadableStreamNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\BigDecimalNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\CountryIsoNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DateTimeUnixTimeNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DiscriminatorDefaultNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DriverLicenseNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DriverLicenseSeriesNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\EmailNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\InnNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\KppNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\MonthNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\PhoneNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianInternationalPassportNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianInternationalPassportSeriesNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianPassportDivisionCodeNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianPassportNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\RussianPassportSeriesNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SfrRegistrationNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SnilsNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\UidFailedNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\YearNormalizer;
use Vanta\Integration\Esia\Struct\Document\Base\BirthDateFile;
use Vanta\Integration\Esia\Struct\Document\Base\BirthPlaceFile;
use Vanta\Integration\Esia\Struct\Document\Base\FullNameFile;
use Vanta\Integration\Esia\Struct\Document\Base\GenderFile;
use Vanta\Integration\Esia\Struct\Document\Base\InnFile;
use Vanta\Integration\Esia\Struct\Document\Base\RussianPassportFile;
use Vanta\Integration\Esia\Struct\Document\Base\SnilsFile;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncome;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncomeFile;
use Vanta\Integration\Esia\Struct\Document\Sfr\PensionFile;
use Vanta\Integration\Esia\Struct\Document\Sfr\WorkbookFile;

final readonly class DocumentParser
{
    public function __construct(
        private Serializer $serializer,
    ) {
    }

    public static function create(?Serializer $serializer = null): self
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $objectNormalizer     = new ObjectNormalizer(
            $classMetadataFactory,
            new MetadataAwareNameConverter($classMetadataFactory),
            null,
            new PropertyInfoExtractor(
                [],
                [new PhpStanExtractor()],
                [],
                [],
                []
            ),
            new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
        );

        $normalizers = [
            new UnwrappingDenormalizer(),
            new BackedEnumNormalizer(),
            new MonthNormalizer(),
            new UidFailedNormalizer(new UidNormalizer()),
            new Base64DecodingReadableStreamNormalizer(),
            new RussianPassportNumberNormalizer(),
            new RussianPassportSeriesNormalizer(),
            new RussianPassportDivisionCodeNormalizer(),
            new RussianInternationalPassportNumberNormalizer(),
            new RussianInternationalPassportSeriesNormalizer(),
            new DriverLicenseNumberNormalizer(),
            new DriverLicenseSeriesNormalizer(),
            new InnNumberNormalizer(),
            new SnilsNumberNormalizer(),
            new SfrRegistrationNumberNormalizer(),
            new KppNumberNormalizer(),
            new CountryIsoNormalizer(),
            new PhoneNumberNormalizer(),
            new EmailNormalizer(),
            new YearNormalizer(),
            new BigDecimalNormalizer(),
            new DateTimeUnixTimeNormalizer(
                new DateTimeNormalizer([
                    DateTimeNormalizer::FORMAT_KEY => 'd.m.Y',
                ])
            ),
            new DiscriminatorDefaultNormalizer($objectNormalizer, $classMetadataFactory),
            new ArrayDenormalizer(),
        ];

        return new self($serializer ?? new SymfonySerializer($normalizers, [new XmlEncoder()]));
    }

    /**
     * @throws ExceptionInterface
     * @throws BufferException
     */
    public function parsePayoutIncome(PayoutIncome $document): PayoutIncomeFile
    {
        return $this->serializer->deserialize(buffer($document->xmlFile->content), PayoutIncomeFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parsePayoutIncomeFile(string $contents): PayoutIncomeFile
    {
        return $this->serializer->deserialize($contents, PayoutIncomeFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseFullNameFile(string $contents): FullNameFile
    {
        return $this->serializer->deserialize($contents, FullNameFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseGenderFile(string $contents): GenderFile
    {
        return $this->serializer->deserialize($contents, GenderFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseBirthDateFile(string $contents): BirthDateFile
    {
        return $this->serializer->deserialize($contents, BirthDateFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseBirthPlaceFile(string $contents): BirthPlaceFile
    {
        return $this->serializer->deserialize($contents, BirthPlaceFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseMobilePhoneFile(string $contents): MobilePhoneFile
    {
        return $this->serializer->deserialize($contents, MobilePhoneFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseEmailFile(string $contents): EmailFile
    {
        return $this->serializer->deserialize($contents, EmailFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseHomeAddressFile(string $contents): HomeAddressFile
    {
        return $this->serializer->deserialize($contents, HomeAddressFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseRegistrationAddressFile(string $contents): RegistrationAddressFile
    {
        return $this->serializer->deserialize($contents, RegistrationAddressFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseRussianPassportFile(string $contents): RussianPassportFile
    {
        return $this->serializer->deserialize($contents, RussianPassportFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseSnilsFile(string $contents): SnilsFile
    {
        return $this->serializer->deserialize($contents, SnilsFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseInnFile(string $contents): InnFile
    {
        return $this->serializer->deserialize($contents, InnFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parsePensionFile(string $contents): PensionFile
    {
        return $this->serializer->deserialize($this->encodeUriNamespaces($contents), PensionFile::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseWorkbookFile(string $contents): WorkbookFile
    {
        return $this->serializer->deserialize($this->encodeUriNamespaces($contents), WorkbookFile::class, 'xml');
    }

    /**
     * Hack for namespaces with Cyrillic NS like this:
     *
     *   xmlns="http://пф.рф/УТ/2017-08-21"
     *
     * Otherwise, libxml throws an error.
     */
    private function encodeUriNamespaces(string $xml): string
    {
        return (string) preg_replace_callback(
            '/\bxmlns(?::\w+)?="([^"]*)"/',
            static function (array $m): string {
                $encoded = preg_replace_callback(
                    '/[^\x20-\x7E]/',
                    static fn (array $c): string => rawurlencode($c[0]),
                    $m[1],
                );

                return str_replace($m[1], (string) $encoded, $m[0]);
            },
            $xml,
        );
    }
}
