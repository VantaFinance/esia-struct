<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Fns;

use Amp\ByteStream\Base64\Base64DecodingReadableStream;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class PayoutIncomeBase64File
{
    public function __construct(
        #[SerializedName('sig')]
        public Base64DecodingReadableStream $sign,
        #[SerializedName('file')]
        public Base64DecodingReadableStream $content,
    ) {
    }
}
