<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2025, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document\Income;

use Brick\Math\BigDecimal;
use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class IncomeReferenceDataItem
{
    /**
     * @param list<IncomeReferenceBase64File>         $files
     * @param list<IncomeReferenceDateItemIncomeInfo> $incomeInfo
     */
    public function __construct(
        #[SerializedName('orgInfo')]
        public ?IncomeReferenceDateItemOrganizationInfo $organizationInfo,
        #[SerializedName('personInfo')]
        public ?IncomeReferenceDateItemPersonInfo $personInfo,
        #[SerializedName('incInfo')]
        public array $incomeInfo = [],
        public array $files = [],
        public ?BigDecimal $rate = null,
        public ?BigDecimal $income = null,
        public ?BigDecimal $tax = null
    ) {
    }

    /**
     * @param non-empty-list<non-empty-string> $types
     *
     * @return array<IncomeReferenceBase64File>
     */
    public function getFilesByTypes(array $types): array
    {
        return array_filter($this->files, static fn (IncomeReferenceBase64File $e): bool => in_array($e->metadata, $types));
    }

    /**
     * Метод доступен только для v3 api
     */
    public function getRate(): BigDecimal
    {
        return $this->rate ?? BigDecimal::zero();
    }

    /**
     * Метод доступен только для v3 api
     */
    public function getIncome(): BigDecimal
    {
        return $this->income ?? BigDecimal::zero();
    }

    /**
     * Метод доступен только для v3 api
     */
    public function getTax(): BigDecimal
    {
        return $this->tax ?? BigDecimal::zero();
    }
}
