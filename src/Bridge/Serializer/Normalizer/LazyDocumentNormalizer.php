<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Brick\DateTime\Year;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as Denormalizer;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\LazyDocument;
use Vanta\Integration\Esia\Struct\Document\LazyIncomeReference;

final readonly class LazyDocumentNormalizer implements Denormalizer
{
    public const TYPE_DOCUMENT = 'lazy.document.type';

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return is_array($data) && array_key_exists('requestId', $data);
    }

    public function getSupportedTypes(?string $format): array
    {
        return ['*' => false];
    }

    /**
     * @param array{"lazy.document.type"?: DocumentType, "deserialization_path"?: non-empty-string} $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): object
    {
        if (!is_array($data)) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('Ожидали массив,получили:%s.', get_debug_type($data)),
                $data,
                [Type::BUILTIN_TYPE_ARRAY],
                $context['deserialization_path'] ?? null,
                true,
            );
        }

        $oid       = $data['oid'] ?? null;
        $requestId = $data['requestId'] ?? null;
        $year      = $data['year'] ?? null;

        if (!is_numeric($oid) || !is_string($oid) || !is_string($requestId) || '' == $requestId) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                'Не найден oid или requestId',
                $data,
                [Type::BUILTIN_TYPE_ARRAY],
                $context['deserialization_path'] ?? null,
                true,
            );
        }

        $documentType = $context[self::TYPE_DOCUMENT] ?? DocumentType::UNKNOWN;

        if (null != $year) {
            return new LazyIncomeReference(
                $oid,
                $requestId,
                Year::parse($year),
            );
        }

        return new LazyDocument(
            $oid,
            $requestId,
            $documentType,
        );
    }
}
