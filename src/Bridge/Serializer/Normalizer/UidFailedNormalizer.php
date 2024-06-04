<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Uid\NilUuid;
use Throwable;

final readonly class UidFailedNormalizer implements Denormalizer
{
    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }

    public function __construct(
        private UidNormalizer $normalizer,
    ) {
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): mixed
    {
        try {
            return $this->normalizer->denormalize($data, $type, $format, $context);
        } catch (Throwable) {
            return new NilUuid();
        }
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return $this->normalizer->supportsDenormalization($data, $type, $format, $context);
    }
}
