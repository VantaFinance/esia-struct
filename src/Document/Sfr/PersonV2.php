<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;

final readonly class PersonV2
{
    public function __construct(
        #[SerializedPath('[УТ6:ФИО][УТ6:Фамилия]')]
        public string $lastName,
        #[SerializedPath('[УТ6:ФИО][УТ6:Имя]')]
        public string $firstName,
        #[SerializedPath('[УТ6:ФИО][УТ6:Отчество]')]
        public ?string $middleName,
        #[SerializedName('УТ6:СНИЛС')]
        public SnilsNumber $snils,
        #[SerializedName('УТ6:ДатаРождения')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public DateTimeImmutable $birthAt,
    ) {
    }
}
