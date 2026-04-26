<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Document;

use function Amp\ByteStream\buffer;

use Amp\ByteStream\BufferException;
use Brick\PhoneNumber\PhoneNumber;
use DateTimeImmutable;
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
use Vanta\Integration\Esia\Struct\Address;
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
use Vanta\Integration\Esia\Struct\Document\Base\EmailFile;
use Vanta\Integration\Esia\Struct\Document\Base\GenderFile;
use Vanta\Integration\Esia\Struct\Document\Base\HomeAddressFile;
use Vanta\Integration\Esia\Struct\Document\Base\InnFile;
use Vanta\Integration\Esia\Struct\Document\Base\MobilePhoneFile;
use Vanta\Integration\Esia\Struct\Document\Base\RegistrationAddressFile;
use Vanta\Integration\Esia\Struct\Document\Base\SnilsFile;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncome;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncomeFile;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncomeV2;
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportV2;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbookV2;
use Vanta\Integration\Esia\Struct\Document\Sfr\IndividualInsuranceAccountStatementV2;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;
use Vanta\Integration\Esia\Struct\Email;
use Vanta\Integration\Esia\Struct\FullName;
use Vanta\Integration\Esia\Struct\Gender;

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
                    DateTimeNormalizer::FORMAT_KEY => 'd.M.Y',
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
    public function parsePayoutIncomeV2File(string $contents): PayoutIncomeV2
    {
        return $this->serializer->deserialize($contents, PayoutIncomeV2::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseFullNameFile(string $contents): FullName
    {
        return $this->serializer->deserialize($contents, FullName::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseGenderFile(string $contents): Gender
    {
        return $this->serializer->deserialize($contents, GenderFile::class, 'xml')->gender;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseBirthDateFile(string $contents): DateTimeImmutable
    {
        return $this->serializer->deserialize($contents, BirthDateFile::class, 'xml')->birthDate;
    }

    /**
     * @throws ExceptionInterface
     * @return non-empty-string
     */
    public function parseBirthPlaceFile(string $contents): string
    {
        return $this->serializer->deserialize($contents, BirthPlaceFile::class, 'xml')->birthPlace;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseMobilePhoneFile(string $contents): PhoneNumber
    {
        return $this->serializer->deserialize($contents, MobilePhoneFile::class, 'xml')->phoneNumber;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseEmailFile(string $contents): Email
    {
        return $this->serializer->deserialize($contents, EmailFile::class, 'xml')->email;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseHomeAddressFile(string $contents): Address
    {
        return $this->serializer->deserialize($contents, HomeAddressFile::class, 'xml')->homeAddress;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseRegistrationAddressFile(string $contents): Address
    {
        return $this->serializer->deserialize($contents, RegistrationAddressFile::class, 'xml')->registrationAddress;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseRussianPassportV2File(string $contents): RussianPassportV2
    {
        return $this->serializer->deserialize($contents, RussianPassportV2::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseSnilsFile(string $contents): SnilsNumber
    {
        return $this->serializer->deserialize($contents, SnilsFile::class, 'xml')->snils;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseInnFile(string $contents): InnNumber
    {
        return $this->serializer->deserialize($contents, InnFile::class, 'xml')->inn;
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseIndividualInsuranceAccountStatementV2File(string $contents): IndividualInsuranceAccountStatementV2
    {
        return $this->serializer->deserialize($this->encodeUriNamespaces($contents), IndividualInsuranceAccountStatementV2::class, 'xml');
    }

    /**
     * @throws ExceptionInterface
     */
    public function parseElectronicWorkbookV2File(string $contents): ElectronicWorkbookV2
    {
        return $this->serializer->deserialize($this->encodeUriNamespaces($contents), ElectronicWorkbookV2::class, 'xml');
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
