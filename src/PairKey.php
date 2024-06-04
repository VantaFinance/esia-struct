<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

use DateTimeImmutable;
use Lcobucci\JWT\Token;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PairKey
{
    /**
     * @param non-empty-string $tokenId
     * @param non-empty-string $tokenType
     * @param positive-int     $expiresIn
     * @param non-empty-string $refreshToken
     */
    public function __construct(
        #[SerializedName('access_token')]
        public Token $accessToken,
        #[SerializedName('token_type')]
        public string $tokenType,
        #[SerializedName('expires_in')]
        public int $expiresIn,
        #[SerializedName('created_at')]
        public DateTimeImmutable $createdAt,
        #[SerializedName('refresh_token')]
        public string $refreshToken,
        #[SerializedName('id_token')]
        public string $tokenId,
    ) {
    }
}
