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
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SafeUnwrappingDenormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SfrRegistrationNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SnilsNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\UidFailedNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\YearNormalizer;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncome;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncomeFile;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncomeV2;
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\Mvd\PreviousDocument;
use Vanta\Integration\Esia\Struct\Document\Mvd\PreviousDocumentV2;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportV2;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbookV2;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbookV3;
use Vanta\Integration\Esia\Struct\Document\Sfr\IndividualInsuranceAccountStatementV2;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;
use Vanta\Integration\Esia\Struct\Email;
use Vanta\Integration\Esia\Struct\FullName;
use Vanta\Integration\Esia\Struct\Gender;
use Vanta\Integration\Esia\Struct\Proof;

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
            new SafeUnwrappingDenormalizer(),
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
     * @throws BufferException
     */
    public function parsePayoutIncome(PayoutIncome $document): ?PayoutIncomeFile
    {
        try {
            return $this->serializer->deserialize(buffer($document->xmlFile->content), PayoutIncomeFile::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parsePayoutIncomeV2File(string $contents): ?PayoutIncomeV2
    {
        try {
            return $this->serializer->deserialize($contents, PayoutIncomeV2::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseFullNameFile(string $contents): ?FullName
    {
        try {
            return $this->serializer->deserialize($contents, FullName::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseGenderFile(string $contents): ?Gender
    {
        try {
            return $this->serializer->deserialize($contents, Gender::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[ns2:gender][ns2:gender]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseBirthDateFile(string $contents): ?DateTimeImmutable
    {
        try {
            return $this->serializer->deserialize($contents, DateTimeImmutable::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[ns2:birthDate][ns2:birthDate]',
                DateTimeNormalizer::FORMAT_KEY          => '!d.m.Y',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    /**
     * @return non-empty-string|null
     */
    public function parseBirthPlaceFile(string $contents): ?string
    {
        try {
            $value = $this->serializer->deserialize($contents, 'string', 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[ns2:birthPlace][ns2:birthPlace]',
            ]);

            if (!is_string($value)) {
                return null;
            }

            $value = trim($value);

            return '' === $value ? null : $value;
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseMobilePhoneFile(string $contents): ?PhoneNumber
    {
        try {
            return $this->serializer->deserialize($contents, PhoneNumber::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[mobilePhone]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseEmailFile(string $contents): ?Email
    {
        try {
            return $this->serializer->deserialize($contents, Email::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[email]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseHomeAddressFile(string $contents): ?Address
    {
        try {
            return $this->serializer->deserialize($contents, Address::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[homeAddress]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseRegistrationAddressFile(string $contents): ?Address
    {
        try {
            return $this->serializer->deserialize($contents, Address::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[registrationAddress]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseRussianPassportV2File(string $contents): ?RussianPassportV2
    {
        try {
            return $this->serializer->deserialize($contents, RussianPassportV2::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseSnilsFile(string $contents): ?SnilsNumber
    {
        try {
            return $this->serializer->deserialize($contents, SnilsNumber::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[snils]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseInnFile(string $contents): ?InnNumber
    {
        try {
            return $this->serializer->deserialize($contents, InnNumber::class, 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[inn]',
            ]);
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseIndividualInsuranceAccountStatementV2File(string $contents): ?IndividualInsuranceAccountStatementV2
    {
        try {
            return $this->serializer->deserialize($this->encodeUriNamespaces($contents), IndividualInsuranceAccountStatementV2::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    /**
     * @deprecated
     * @see self::parseElectronicWorkbookV3File
     */
    public function parseElectronicWorkbookV2File(string $contents): ?ElectronicWorkbookV2
    {
        try {
            return $this->serializer->deserialize($this->encodeUriNamespaces($contents), ElectronicWorkbookV2::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    public function parseElectronicWorkbookV3File(string $contents): ?ElectronicWorkbookV3
    {
        try {
            return $this->serializer->deserialize($this->encodeUriNamespaces($contents), ElectronicWorkbookV3::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
    }

    /**
     * @return list<PreviousDocument>
     */
    public function parsePassportHistoryV2File(string $contents): array
    {
        try {
            /** @var list<PreviousDocument>|null $history */
            $history = $this->serializer->deserialize($this->encodeUriNamespaces($contents), PreviousDocumentV2::class . '[]', 'xml', [
                SafeUnwrappingDenormalizer::UNWRAP_PATH => '[ns2:passportHistoryType]',
            ]);

            return $history ?? [];
        } catch (ExceptionInterface) {
            return [];
        }
    }

    public function parseProofFile(string $contents): ?Proof
    {
        try {
            return $this->serializer->deserialize($this->encodeUriNamespaces($contents), Proof::class, 'xml');
        } catch (ExceptionInterface) {
            return null;
        }
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
            '~https?://[^\s"\'<>]+~',
            static fn (array $m): string => preg_match('/[^\x00-\x7F]/', $m[0])
                ? 'https://vanta.ru'
                : $m[0],
            $xml,
        );
    }
}
