<?php

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface as DenormalizerAware;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DenormalizationFallback;

final class FallbackDenormalizer implements Denormalizer, DenormalizerAware
{
    private const ALREADY_CALLED_DENORMALIZER = 'fallback.already_called_denormalizer';

    use DenormalizerAwareTrait;

    /**
     * @throws \ReflectionException
     * @throws ExceptionInterface
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        $attributes = (new \ReflectionClass($type))->getAttributes(FallbackDenormalizer::class);
        $newContext = [self::ALREADY_CALLED_DENORMALIZER => true, ... $context];


        if ($attributes == []){
            return $this->denormalizer->denormalize($data, $type, $format, $newContext);
        }

        /** @var DenormalizationFallback $attribute */
        $attribute = $attributes[0]->newInstance();


        try {
            return $this->denormalizer->denormalize($data, $type, $format, $newContext);
        }catch (\Throwable){
            return $this->denormalizer->denormalize($data, $attribute->class, $format, $context);
        }
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return !array_key_exists(self::ALREADY_CALLED_DENORMALIZER, $context);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['object' => true];
    }
}