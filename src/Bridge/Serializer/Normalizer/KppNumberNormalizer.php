<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Vanta\Integration\Esia\Struct\Document\KppNumber;
use Webmozart\Assert\Assert;

final readonly class KppNumberNormalizer implements Normalizer, Denormalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return [KppNumber::class => true];
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization($data, string $type, ?string $format = null, array $context = []): bool
    {
        return KppNumber::class == $type;
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array{deserialization_path?: non-empty-string} $context
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = []): KppNumber
    {
        if (is_int($data)) {
            $data = (string) $data;
        }

        try {
            Assert::numeric($data);
            Assert::string($data);

            return new KppNumber($data);
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
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof KppNumber;
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
        if (!$object instanceof KppNumber) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', KppNumber::class));
        }

        return $object->value;
    }
}
