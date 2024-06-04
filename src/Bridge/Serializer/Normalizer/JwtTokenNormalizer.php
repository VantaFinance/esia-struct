<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer;

use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Parser;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

final readonly class JwtTokenNormalizer implements DenormalizerInterface
{
    public function __construct(
        private Parser $jwtParser = new Parser(new JoseEncoder())
    ) {
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Token::class => true,
        ];
    }

    /**
     * @param array{deserialization_path?: string} $context
     */
    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = []): Token
    {
        if ($data instanceof Token) {
            return $data;
        }

        if (!is_string($data) || '' == $data) {
            throw NotNormalizableValueException::createForUnexpectedDataType(
                sprintf('Ожидали строку,получили:%s.', get_debug_type($data)),
                $data,
                [Type::BUILTIN_TYPE_STRING],
                $context['deserialization_path'] ?? null,
                true,
            );
        }

        return $this->jwtParser->parse($data);
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null, array $context = []): bool
    {
        return Token::class == $type;
    }
}
