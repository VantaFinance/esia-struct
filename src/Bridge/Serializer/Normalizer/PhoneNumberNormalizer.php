<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Webmozart\Assert\Assert;

final readonly class PhoneNumberNormalizer implements Denormalizer, Normalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return [PhoneNumber::class => true];
    }

    /**
     * @param string                    $data
     * @param class-string<PhoneNumber> $type
     * @param array<string>             $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): PhoneNumber
    {
        try {
            Assert::stringNotEmpty($data);

            return PhoneNumber::parse($data, 'RU');
        } catch (PhoneNumberException $e) {
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
    public function supportsDenormalization($data, ?string $type = null, ?string $format = null, array $context = []): bool
    {
        return PhoneNumber::class === $type;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        if (!$object instanceof PhoneNumber) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', PhoneNumber::class));
        }

        return $object->jsonSerialize();
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof PhoneNumber;
    }
}
