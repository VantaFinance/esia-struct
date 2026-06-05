<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Throwable;

/**
 * NOTE: Both timestamps are optional and both are in MILLISECONDS.
 * E.g. `1776685319599`, not `1776685319` or `1776685319.599`.
 */
final readonly class Proof
{
    public function __construct(
        #[SerializedPath('[ProofRecord][ProofBlock][ns2:status]')]
        public VerificationStatus $verificationStatus,
        #[SerializedPath('[ProofRecord][ProofBlock][ns2:receiptDocDate]')]
        public ?int $receiptDocTimestamp,
        #[SerializedPath('[ProofRecord][ProofBlock][ns2:validateDateDoc]')]
        public ?int $validateDocTimestamp,
    ) {
    }

    /**
     * @throws Throwable
     */
    public function getReceiptDocDate(): ?DateTimeImmutable
    {
        if (null === $this->receiptDocTimestamp) {
            return null;
        }

        return new DateTimeImmutable('@' . intdiv($this->receiptDocTimestamp, 1000));
    }

    /**
     * @throws Throwable
     */
    public function getValidateDocDate(): ?DateTimeImmutable
    {
        if (null === $this->validateDocTimestamp) {
            return null;
        }

        return new DateTimeImmutable('@' . intdiv($this->validateDocTimestamp, 1000));
    }
}
