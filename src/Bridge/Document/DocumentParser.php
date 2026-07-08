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
use InvalidArgumentException;
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
use TypeError;
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
use Vanta\Integration\Esia\Struct\Document\ParsedEmail;
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

    /**
     * @param array<string, mixed> $context
     */
    private function deserializeXmlOrNull(string $contents, string $type, array $context = []): mixed
    {
        try {
            return $this->serializer->deserialize($this->encodeUriNamespaces($contents), $type, 'xml', $context);
        } catch (ExceptionInterface|TypeError) {
            return null;
        }
    }

    public function parsePayoutIncomeV2File(string $contents): ?PayoutIncomeV2
    {
        /**
         * @var ?PayoutIncomeV2
         */
        return $this->deserializeXmlOrNull($contents, PayoutIncomeV2::class);
    }

    public function parseFullNameFile(string $contents): ?FullName
    {
        /**
         * @var ?FullName
         */
        return $this->deserializeXmlOrNull($contents, FullName::class);
    }

    public function parseGenderFile(string $contents): ?Gender
    {
        /**
         * @var ?Gender
         */
        return $this->deserializeXmlOrNull($contents, Gender::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[ns2:gender][ns2:gender]',
        ]);
    }

    public function parseBirthDateFile(string $contents): ?DateTimeImmutable
    {
        /**
         * @var ?DateTimeImmutable
         */
        return $this->deserializeXmlOrNull($contents, DateTimeImmutable::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[ns2:birthDate][ns2:birthDate]',
            DateTimeNormalizer::FORMAT_KEY      => '!d.m.Y',
        ]);
    }

    /**
     * @return non-empty-string|null
     */
    public function parseBirthPlaceFile(string $contents): ?string
    {
        $value = $this->deserializeXmlOrNull($contents, 'string', [
            UnwrappingDenormalizer::UNWRAP_PATH => '[ns2:birthPlace][ns2:birthPlace]',
        ]);

        if (!is_string($value)) {
            return null;
        }

        $value = trim($value);

        /**
         * @var non-empty-string|null
         */
        return '' === $value ? null : $value;
    }

    public function parseMobilePhoneFile(string $contents): ?PhoneNumber
    {
        /**
         * @var ?PhoneNumber
         */
        return $this->deserializeXmlOrNull($contents, PhoneNumber::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[mobilePhone]',
        ]);
    }

    public function parseEmailFile(string $contents): ?ParsedEmail
    {
        $value = $this->deserializeXmlOrNull($contents, 'string', [
            UnwrappingDenormalizer::UNWRAP_PATH => '[email]',
        ]);

        /**
         * @var ?ParsedEmail
         */
        return is_string($value) ? $this->parseEmailValue($value) : null;
    }

    private function parseEmailValue(string $value): ?ParsedEmail
    {
        $value = preg_replace('/\s+/u', '', $value) ?? '';
        /** @var non-empty-string $value */
        $value = preg_replace('/^mailto:/i', '', $value) ?? '';

        if (null !== $email = $this->createEmailOrNull($value)) {
            return $email;
        }

        if (preg_match('/[A-Z0-9._%+\-]+@[A-Z0-9.\-]+\.[A-Z]{2,}/i', $value, $matches)) {
            return $this->createEmailOrNull($matches[0]);
        }

        return null;
    }

    /**
     * @param non-empty-string $value
     */
    private function createEmailOrNull(string $value): ?ParsedEmail
    {
        try {
            return new ParsedEmail($value, new Email($value));
        } catch (InvalidArgumentException) {
            return null;
        }
    }

    public function parseHomeAddressFile(string $contents): ?Address
    {
        /**
         * @var ?Address
         */
        return $this->deserializeXmlOrNull($contents, Address::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[homeAddress]',
        ]);
    }

    public function parseRegistrationAddressFile(string $contents): ?Address
    {
        /**
         * @var ?Address
         */
        return $this->deserializeXmlOrNull($contents, Address::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[registrationAddress]',
        ]);
    }

    public function parseRussianPassportV2File(string $contents): ?RussianPassportV2
    {
        /**
         * @var ?RussianPassportV2
         */
        return $this->deserializeXmlOrNull($contents, RussianPassportV2::class);
    }

    public function parseSnilsFile(string $contents): ?SnilsNumber
    {
        /**
         * @var ?SnilsNumber
         */
        return $this->deserializeXmlOrNull($contents, SnilsNumber::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[snils]',
        ]);
    }

    public function parseInnFile(string $contents): ?InnNumber
    {
        /**
         * @var ?InnNumber
         */
        return $this->deserializeXmlOrNull($contents, InnNumber::class, [
            UnwrappingDenormalizer::UNWRAP_PATH => '[inn]',
        ]);
    }

    public function parseIndividualInsuranceAccountStatementV2File(string $contents): ?IndividualInsuranceAccountStatementV2
    {
        /**
         * @var ?IndividualInsuranceAccountStatementV2
         */
        return $this->deserializeXmlOrNull($contents, IndividualInsuranceAccountStatementV2::class);
    }

    /**
     * @deprecated
     * @see self::parseElectronicWorkbookV3File
     */
    public function parseElectronicWorkbookV2File(string $contents): ?ElectronicWorkbookV2
    {
        /**
         * @var ?ElectronicWorkbookV2
         */
        return $this->deserializeXmlOrNull($contents, ElectronicWorkbookV2::class);
    }

    public function parseElectronicWorkbookV3File(string $contents): ?ElectronicWorkbookV3
    {
        /**
         * @var ?ElectronicWorkbookV3
         */
        return $this->deserializeXmlOrNull($contents, ElectronicWorkbookV3::class);
    }

    /**
     * @return list<PreviousDocument>
     */
    public function parsePassportHistoryV2File(string $contents): array
    {
        $context = [
            UnwrappingDenormalizer::UNWRAP_PATH => '[ns2:passportHistoryType]',
        ];

        /** @var list<PreviousDocument>|null $history */
        $history = $this->deserializeXmlOrNull($contents, PreviousDocumentV2::class . '[]', $context);

        // ArrayDenormalizer does not understand when there is only one `passportHistoryType` node in XML.
        // @phpstan-ignore-next-line
        if (is_array($history) && array_is_list($history)) {
            return $history;
        }

        $document = $this->deserializeXmlOrNull($contents, PreviousDocumentV2::class, $context);

        return $document instanceof PreviousDocument ? [$document] : [];
    }

    public function parseProofFile(string $contents): ?Proof
    {
        /**
         * @var ?Proof
         */
        return $this->deserializeXmlOrNull($contents, Proof::class);
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
