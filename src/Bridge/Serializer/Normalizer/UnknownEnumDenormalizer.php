<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use BackedEnum;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;

/**
 * Denormalizes an enum that declares an `UNKNOWN` case: a value the catalog does not know becomes
 * `UNKNOWN` instead of failing the whole document. Normalization stays with `BackedEnumNormalizer`;
 * register this denormalizer before it.
 *
 * Not registered in {@see \Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser}.
 */
final readonly class UnknownEnumDenormalizer implements Denormalizer
{
    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $path = $context['deserialization_path'] ?? null;
        $path = is_string($path) ? $path : null;

        if (!is_string($data) && !is_int($data)) {
            throw NotNormalizableValueException::createForUnexpectedDataType('The data must be a string or an integer.', $data, ['string', 'int'], $path, true);
        }

        /** @var class-string<BackedEnum> $type */
        $unknown = constant($type . '::UNKNOWN');

        if (!$unknown instanceof BackedEnum) {
            throw NotNormalizableValueException::createForUnexpectedDataType('UNKNOWN is not an enum case.', $data, ['string'], $path);
        }

        // tryFrom() is strictly typed: align the wire value with the backing type first.
        if (is_int($unknown->value)) {
            if (is_string($data) && 1 !== preg_match('/^-?\d+\z/', $data)) {
                return $unknown;
            }

            $data = (int) $data;
        } else {
            $data = (string) $data;
        }

        return $type::tryFrom($data) ?? $unknown;
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_subclass_of($type, BackedEnum::class) && defined($type . '::UNKNOWN');
    }

    /**
     * The answer depends only on the type, so Symfony may cache it per enum class.
     */
    public function getSupportedTypes(?string $format): array
    {
        return [BackedEnum::class => true];
    }
}
