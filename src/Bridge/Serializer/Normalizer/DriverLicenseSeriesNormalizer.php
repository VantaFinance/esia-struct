<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Vanta\Integration\Esia\Struct\Document\DriverLicense\RussianDriverLicenseSeries;
use Webmozart\Assert\Assert;

final readonly class DriverLicenseSeriesNormalizer implements Normalizer, Denormalizer
{
    /**
     * @return array<class-string, true>
     */
    public function getSupportedTypes(?string $format): array
    {
        return [RussianDriverLicenseSeries::class => true];
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return RussianDriverLicenseSeries::class == $type;
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array{deserialization_path?: non-empty-string} $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): RussianDriverLicenseSeries
    {
        try {
            Assert::stringNotEmpty($data);

            return new RussianDriverLicenseSeries($data);
        } catch (InvalidArgumentException $e) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                $e->getMessage(),
                $data,
                [Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true
            );
        }
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof RussianDriverLicenseSeries;
    }

    /**
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param object               $object
     * @param array<string, mixed> $context
     *
     * @return non-empty-string
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        if (!$object instanceof RussianDriverLicenseSeries) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', RussianDriverLicenseSeries::class));
        }

        return $object->value;
    }
}
