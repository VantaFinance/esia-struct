<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Contact;

use Symfony\Component\Serializer\Attribute\DiscriminatorMap;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;
use Vanta\Integration\Esia\Struct\Person\DataVerificationStatus;
use Vanta\Integration\Esia\Struct\Person\VerifyingStatus;

/**
 * Контакт пользователя (элемент `contacts`). Контакт неизвестного типа или с невалидным значением
 * разбирается в {@see UnknownContact}.
 */
#[DiscriminatorDefault(UnknownContact::class)]
#[DiscriminatorMap('type', [
    'MBT' => ContactPhoneNumber::class,
    'PHN' => ContactPhoneNumber::class,
    'EML' => ContactEmail::class,
])]
abstract readonly class Contact
{
    /**
     * @param DataVerificationStatus|null $vrfStu         статус верификации
     * @param VerifyingStatus|null        $vrfValStu      статус процесса подтверждения
     * @param non-empty-string|null       $verifyingValue значение, которое проходит подтверждение
     */
    public function __construct(
        public ContactType $type,
        public ?DataVerificationStatus $vrfStu = null,
        public ?VerifyingStatus $vrfValStu = null,
        public ?string $verifyingValue = null,
    ) {
    }
}
