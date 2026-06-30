<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface as PropertyAccessException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface as PropertyAccessor;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerAwareInterface as SerializerAware;
use Symfony\Component\Serializer\SerializerAwareTrait;

final class SafeUnwrappingDenormalizer implements Denormalizer, SerializerAware
{
    use SerializerAwareTrait;

    public const UNWRAP_PATH = UnwrappingDenormalizer::UNWRAP_PATH;

    private readonly PropertyAccessor $propertyAccessor;

    public function __construct(?PropertyAccessor $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor ?? PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param array<string, mixed> $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $propertyPath         = $context[self::UNWRAP_PATH];
        $context['unwrapped'] = true;

        if ($propertyPath) {
            if (!\is_array($data) && !\is_object($data)) {
                return null;
            }

            if (!$this->propertyAccessor->isReadable($data, $propertyPath)) {
                return null;
            }

            try {
                $data = $this->propertyAccessor->getValue($data, $propertyPath);
            } catch (PropertyAccessException) {
                return null;
            }

            if (null === $data) {
                return null;
            }

            if (\str_ends_with($type, '[]') && (!\is_array($data) || !\array_is_list($data))) {
                $data = [$data];
            }
        }

        if (!$this->serializer instanceof Denormalizer) {
            throw new LogicException('Cannot unwrap path because the injected serializer is not a denormalizer.');
        }

        return $this->serializer->denormalize($data, $type, $format, $context);
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return \array_key_exists(self::UNWRAP_PATH, $context) && !isset($context['unwrapped']);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }
}
