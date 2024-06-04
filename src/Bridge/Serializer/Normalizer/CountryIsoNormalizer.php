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
use Vanta\Integration\Esia\Struct\CountryIso;

final class CountryIsoNormalizer implements Normalizer, Denormalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return [CountryIso::class => true];
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return CountryIso::class == $type;
    }

    /**
     * @param array{deserialization_path?: non-empty-string} $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): CountryIso
    {
        if (!\is_string($data)) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('Ожидали строку, получили:%s.', get_debug_type($data)),
                $data,
                [Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true
            );
        }

        if ('' == $data) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                'Ожидали не пустую строку',
                $data,
                [Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true
            );
        }

        try {
            return new CountryIso($data);
        } catch (InvalidArgumentException $e) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                $e->getMessage(),
                $data,
                [Type::BUILTIN_TYPE_INT, Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true
            );
        }
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof CountryIso;
    }

    /**
     * @param object               $object
     * @param array<string, mixed> $context
     *
     * @return non-empty-string
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        if (!$object instanceof CountryIso) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', CountryIso::class));
        }

        return $object->value;
    }
}
