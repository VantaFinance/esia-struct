<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface as ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerAwareInterface as SerializerAware;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;

final readonly class DiscriminatorDefaultNormalizer implements Denormalizer, SerializerAware
{
    public function __construct(
        private ObjectNormalizer $objectNormalizer,
        private ClassMetadataFactory $metadataFactory,
    ) {
    }

    /**
     * @psalm-suppress MissingParamType
     *
     * @param array{deserialization_path?: non-empty-string, key_type?: non-empty-string} $context
     *
     * @throws Throwable
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $mapping         = $this->metadataFactory->getMetadataFor($type);
        $reflectionClass = $mapping->getReflectionClass();
        $discriminator   = $mapping->getClassDiscriminatorMapping();

        if (null === $discriminator) {
            return $this->objectNormalizer->denormalize($data, $type, $format, $context);
        }

        $attribute = $reflectionClass->getAttributes(DiscriminatorDefault::class)[0] ?? null;
        $attribute = $attribute?->newInstance();

        try {
            return $this->objectNormalizer->denormalize($data, $type, $format, $context);
        } catch (Throwable $e) {
            $context['esia_errors'][] = $e;

            if (null != $attribute) {
                return $this->objectNormalizer->denormalize($data, $attribute->class, $format, $context);
            }

            throw $e;
        }
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->objectNormalizer->supportsDenormalization($data, $type, $format, $context);
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->objectNormalizer->getSupportedTypes($format);
    }

    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->objectNormalizer->setSerializer($serializer);
    }
}
