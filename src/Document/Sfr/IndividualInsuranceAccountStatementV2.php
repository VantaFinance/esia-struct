<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Sfr;

use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;

final readonly class IndividualInsuranceAccountStatementV2 extends Document
{
    /**
     * @param list<PensionCoefficientDataSince2015> $coefficientDataSince2015
     */
    public function __construct(
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns2:ЗЛ]')]
        public Person $person,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns3:ИПК]')]
        public BigDecimal $coefficient,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns3:Стаж]')]
        public PensionWorkTimeRecord $workTimeRecord,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns2:СведенияИПК][ns2:До2015]')]
        public PensionCoefficientDataUntil2015 $coefficientDataUntil2015,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns2:СведенияИПК][ns2:С2015][ns2:ЗаГод]')]
        public array $coefficientDataSince2015,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns2:РасчетИПКДо2015][ns2:До2002]')]
        public PensionCoefficientCalculationUntil2002 $coefficientCalculationUntil2002,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns2:РасчетИПКДо2015][ns2:РПК]')]
        public PensionCoefficientCalculationUntil2015 $coefficientCalculationUntil2015,
        #[SerializedPath('[ns2:СЗИ-ИЛС][ns2:НПФ]')]
        public ?PensionPrivateFund $privateFund,
    ) {
        parent::__construct(DocumentType::ILS_PFR_V2);
    }
}
