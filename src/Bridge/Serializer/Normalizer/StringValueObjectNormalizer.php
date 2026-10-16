<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use InvalidArgumentException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Vanta\Integration\Esia\Struct\StringValueObject;

/**
 * (De)normalizes every {@see StringValueObject}: a non-empty string becomes `new $type($data)`; a value
 * the object rejects becomes `NotNormalizableValueException` carrying the object's message.
 *
 * Not registered in {@see \Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser}: the per-type
 * normalizers stay there unchanged.
 */
final readonly class StringValueObjectNormalizer implements Normalizer, Denormalizer
{
    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        if (!is_a($type, StringValueObject::class, true)) {
            throw new UnexpectedValueException('Unsupported value object.');
        }

        $path = $context['deserialization_path'] ?? null;
        $path = is_string($path) ? $path : null;

        if (!is_string($data) || '' === $data) {
            throw NotNormalizableValueException::createForUnexpectedDataType('The data must be a non-empty string.', $data, ['string'], $path, true);
        }

        try {
            return new $type($data);
        } catch (InvalidArgumentException $e) {
            throw NotNormalizableValueException::createForUnexpectedDataType($e->getMessage(), $data, ['string'], $path, true, previous: $e);
        }
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_a($type, StringValueObject::class, true);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function normalize(mixed $data, ?string $format = null, array $context = []): string
    {
        if (!$data instanceof StringValueObject) {
            throw new UnexpectedValueException('Unsupported value object.');
        }

        return (string) $data;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof StringValueObject;
    }

    /**
     * Symfony also matches a supported type by `is_subclass_of()`, so the interface covers every implementation.
     */
    public function getSupportedTypes(?string $format): array
    {
        return [StringValueObject::class => true];
    }
}
