<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Contact;

use Brick\PhoneNumber\PhoneNumber;
use Vanta\Integration\Esia\Struct\Person\DataVerificationStatus;
use Vanta\Integration\Esia\Struct\Person\VerifyingStatus;

/**
 * Телефон: мобильный (`MBT`) или домашний (`PHN`).
 */
final readonly class ContactPhoneNumber extends Contact
{
    /**
     * @param non-empty-string|null $verifyingValue
     */
    public function __construct(
        public PhoneNumber $value,
        ContactType $type,
        ?DataVerificationStatus $vrfStu = null,
        ?VerifyingStatus $vrfValStu = null,
        ?string $verifyingValue = null,
    ) {
        parent::__construct($type, $vrfStu, $vrfValStu, $verifyingValue);
    }
}
