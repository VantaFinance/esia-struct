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
        #[SerializedPath('[УТ8:ФИО][УТ8:Фамилия]')]
        public string $lastName,
        #[SerializedPath('[УТ8:ФИО][УТ8:Имя]')]
        public string $firstName,
        #[SerializedPath('[УТ8:ФИО][УТ8:Отчество]')]
        public ?string $middleName,
        #[SerializedName('УТ8:СНИЛС')]
        public SnilsNumber $snils,
        #[SerializedName('УТ8:ДатаРождения')]
        #[Context(
            normalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'],
            denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!Y-m-d'],
        )]
        public DateTimeImmutable $birthAt,
    ) {
    }
}
