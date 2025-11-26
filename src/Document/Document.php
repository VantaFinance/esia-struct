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
use Vanta\Integration\Esia\Struct\Document\Fns\IncomeReference;
use Vanta\Integration\Esia\Struct\Document\Fns\PayoutIncome;
use Vanta\Integration\Esia\Struct\Document\Mvd\PassportHistory;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianInternationalPassport;
use Vanta\Integration\Esia\Struct\Document\Mvd\RussianPassport;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbook\ElectronicWorkbook;
use Vanta\Integration\Esia\Struct\Document\Sfr\IndividualInsuranceAccount\IndividualInsuranceAccountStatement;
use Vanta\Integration\Esia\Struct\Document\TrafficPolice\RussianDriverLicense;

#[DiscriminatorDefault(UnknownDocument::class)]
#[Serializer\DiscriminatorMap(
    typeProperty: 'type',
    mapping: [
        DocumentType::PAYOUT_INCOME->value                  => PayoutIncome::class,
        DocumentType::RUSSIAN_PASSPORT->value               => RussianPassport::class,
        DocumentType::PASSPORT_HISTORY->value               => PassportHistory::class,
        DocumentType::INCOME_REFERENCE->value               => IncomeReference::class,
        DocumentType::ELECTRONIC_WORKBOOK->value            => ElectronicWorkbook::class,
        DocumentType::RUSSIAN_DRIVER_LICENSE->value         => RussianDriverLicense::class,
        DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT->value => RussianInternationalPassport::class,
        DocumentType::ILS_PFR->value                        => IndividualInsuranceAccountStatement::class,
    ],
)]
abstract readonly class Document
{
    public function __construct(
        public DocumentType $type
    ) {
    }
}
