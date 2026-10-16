<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person\Document;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer as ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportDivisionCode;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportNumber;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassportSeries;
use Vanta\Integration\Esia\Struct\Person\DataVerificationStatus;

/**
 * Паспорт гражданина РФ (`RF_PASSPORT`).
 */
final readonly class PersonRussianPassport extends PersonDocument
{
    /**
     * @param numeric-string                   $id        идентификатор документа в ЕСИА
     * @param RussianPassportNumber            $number    номер паспорта
     * @param RussianPassportSeries            $series    серия паспорта
     * @param DateTimeImmutable                $issueDate дата выдачи (время 00:00:00)
     * @param DataVerificationStatus           $vrfStu    статус верификации
     * @param RussianPassportDivisionCode|null $issueId   код подразделения, выдавшего паспорт
     * @param non-empty-string|null            $issuedBy  наименование подразделения, выдавшего паспорт
     */
    public function __construct(
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public string $id,
        public RussianPassportNumber $number,
        public RussianPassportSeries $series,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public DateTimeImmutable $issueDate,
        public DataVerificationStatus $vrfStu,
        public ?RussianPassportDivisionCode $issueId = null,
        public ?string $issuedBy = null,
    ) {
        parent::__construct(DocumentType::RUSSIAN_PASSPORT);
    }
}
