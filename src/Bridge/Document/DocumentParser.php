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
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SnilsNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\UidFailedNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\YearNormalizer;
use Vanta\Integration\Esia\Struct\Document\Income\PayoutIncome;
use Vanta\Integration\Esia\Struct\Document\Income\PayoutIncomeFile;

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
}
