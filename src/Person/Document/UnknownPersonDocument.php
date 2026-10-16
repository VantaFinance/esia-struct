<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Document;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Person\DataVerificationStatus;

/**
 * Документ, который не удалось разобрать: неизвестный тип (`rawType`) или данные, не прошедшие
 * проверку (например, серия паспорта не из 4 цифр). `type` всегда {@see DocumentType::UNKNOWN}.
 */
final readonly class UnknownPersonDocument extends PersonDocument
{
    /**
     * @param string|null $rawType тип документа, как его прислала ЕСИА
     */
    public function __construct(
        #[SerializedPath('[type]')]
        public ?string $rawType = null,
        public ?DataVerificationStatus $vrfStu = null,
    ) {
        parent::__construct(DocumentType::UNKNOWN);
    }
}
