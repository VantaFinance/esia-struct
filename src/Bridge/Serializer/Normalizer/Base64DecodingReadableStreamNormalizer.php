<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */
declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use Amp\ByteStream\ReadableResourceStream;
use Amp\ByteStream\StreamException;
use InvalidArgumentException;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Webmozart\Assert\Assert;

final class Base64DecodingReadableStreamNormalizer implements Denormalizer
{
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Base64DecodingReadableStream
    {
        try {
            Assert::stringNotEmpty($data);

            $stream = fopen('php://memory', 'r+');

            Assert::resource($stream);

            fwrite($stream, $data);
            rewind($stream);

            return new Base64DecodingReadableStream(new ReadableResourceStream($stream));
        } catch (InvalidArgumentException|StreamException $e) {
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
     * @param array<string, mixed> $context
     */
    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Base64DecodingReadableStream::class == $type;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Base64DecodingReadableStream::class => true];
    }
}
