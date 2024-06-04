<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

use Symfony\Component\Serializer\Annotation as Serializer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Attribute\DiscriminatorDefault;
use Vanta\Integration\Esia\Struct\Document\DriverLicense\RussianDriverLicense;
use Vanta\Integration\Esia\Struct\Document\ElectronicWorkbook\ElectronicWorkbook;
use Vanta\Integration\Esia\Struct\Document\Income\IncomeReference;
use Vanta\Integration\Esia\Struct\Document\Passport\PassportHistory;
use Vanta\Integration\Esia\Struct\Document\Passport\RussianInternationalPassport;
use Vanta\Integration\Esia\Struct\Document\Passport\RussianPassport;

#[DiscriminatorDefault(UnknownDocument::class)]
#[Serializer\DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        DocumentType::RUSSIAN_PASSPORT->value               => RussianPassport::class,
        DocumentType::RUSSIAN_DRIVER_LICENSE->value         => RussianDriverLicense::class,
        DocumentType::INCOME_REFERENCE->value               => IncomeReference::class,
        DocumentType::PASSPORT_HISTORY->value               => PassportHistory::class,
        DocumentType::ELECTRONIC_WORKBOOK->value            => ElectronicWorkbook::class,
        DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT->value => RussianInternationalPassport::class,
    ],
)]
abstract readonly class Document
{
    public function __construct(
        public DocumentType $type
    ) {
    }
}
