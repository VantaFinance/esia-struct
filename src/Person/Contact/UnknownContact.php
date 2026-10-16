<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Contact;

use Symfony\Component\Serializer\Attribute\SerializedPath;
use Vanta\Integration\Esia\Struct\Person\DataVerificationStatus;

/**
 * Контакт, который не удалось разобрать: неизвестный тип (`rawType`) или значение, не прошедшее
 * проверку (например, адрес почты с кириллическим доменом). `type` всегда {@see ContactType::UNKNOWN}.
 */
final readonly class UnknownContact extends Contact
{
    /**
     * @param string|null $rawType тип контакта, как его прислала ЕСИА
     * @param string|null $value   значение контакта, как его прислала ЕСИА
     */
    public function __construct(
        #[SerializedPath('[type]')]
        public ?string $rawType = null,
        public ?string $value = null,
        ?DataVerificationStatus $vrfStu = null,
    ) {
        parent::__construct(ContactType::UNKNOWN, $vrfStu);
    }
}
