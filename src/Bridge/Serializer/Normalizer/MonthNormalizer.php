<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Brick\DateTime\Month;
use Brick\DateTime\Year;
use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface as Normalizer;
use Webmozart\Assert\Assert;

final readonly class MonthNormalizer implements Denormalizer, Normalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return [Month::class => true];
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Month
    {
        if (is_string($data)) {
            $data = (int) ltrim($data, '0');
        }

        try {

            Assert::integer($data);

            return Month::of($data);
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

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Month::class === $type;
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array<string, mixed> $context
     */
    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Month;
    }

    /**
     * @psalm-suppress MoreSpecificImplementedParamType
     *
     * @param object               $object
     * @param array<string, mixed> $context
     *
     * @return numeric-string
     */
    public function normalize($object, ?string $format = null, array $context = []): string
    {
        if (!$object instanceof Month) {
            throw new UnexpectedValueException(sprintf('Allowed type: %s', Year::class));
        }

        return sprintf('%02d', $object->getValue());
    }
}
