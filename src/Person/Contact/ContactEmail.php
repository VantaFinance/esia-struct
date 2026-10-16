<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Contact;

use Vanta\Integration\Esia\Struct\Email;
use Vanta\Integration\Esia\Struct\Person\DataVerificationStatus;
use Vanta\Integration\Esia\Struct\Person\VerifyingStatus;

/**
 * Адрес электронной почты (`EML`).
 */
final readonly class ContactEmail extends Contact
{
    /**
     * @param non-empty-string|null $verifyingValue
     */
    public function __construct(
        public Email $value,
        ?DataVerificationStatus $vrfStu = null,
        ?VerifyingStatus $vrfValStu = null,
        ?string $verifyingValue = null,
    ) {
        parent::__construct(ContactType::EMAIL, $vrfStu, $vrfValStu, $verifyingValue);
    }
}
