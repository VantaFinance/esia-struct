<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The PosCredit
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;

final readonly class PensionPerson
{
    public function __construct(
        #[SerializedPath('[ФИО][Фамилия]')]
        public string $lastName,
        #[SerializedPath('[ФИО][Имя]')]
        public string $firstName,
        #[SerializedPath('[ФИО][Отчество]')]
        public ?string $middleName,
        #[SerializedName('СНИЛС')]
        public SnilsNumber $snils,
        #[SerializedName('ДатаРождения')]
        #[Context(context: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'])]
        public DateTimeImmutable $birthAt,
    ) {
    }
}
