<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use Brick\DateTime\Year;
use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\Sfr\PensionPrivateFund;

final class IndividualInsuranceAccountStatementV2FileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     * @throws MathException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('ils_pfr.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseIndividualInsuranceAccountStatementV2File($contents);

        $this->assertEquals(DocumentType::ILS_PFR_V2, $output->type);

        $this->assertEquals('БАШМАЧКИН', $output->person->lastName);
        $this->assertEquals('АКАКИЙ', $output->person->firstName);
        $this->assertEquals('АКАКИЕВИЧ', $output->person->middleName);
        $this->assertEquals('123-456-789 00', $output->person->snils->value);
        $this->assertEquals('01.04.1989', $output->person->birthAt->format('d.m.Y'));

        $this->assertTrue(BigDecimal::of('88.369')->isEqualTo($output->coefficient));
        $this->assertEquals(16, $output->workTimeRecord->years);
        $this->assertEquals(0, $output->workTimeRecord->months);
        $this->assertEquals(21, $output->workTimeRecord->days);

        $this->assertTrue(BigDecimal::of('16.922')->isEqualTo($output->coefficientDataUntil2015->coefficient));
        $this->assertEquals(5, $output->coefficientDataUntil2015->workTimeRecord->years);
        $this->assertEquals(3, $output->coefficientDataUntil2015->workTimeRecord->months);
        $this->assertEquals(3, $output->coefficientDataUntil2015->workTimeRecord->days);

        $item = $output->coefficientDataSince2015[0];
        $this->assertTrue(Year::parse('2015')->isEqualTo($item->year));
        $this->assertTrue(BigDecimal::of('7.390')->isEqualTo($item->coefficient));

        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ БЕГЕМОТ', trim($item->byEmployers[0]->name));
        $this->assertEquals('087-999-000005', $item->byEmployers[0]->sfrRegistrationNumber->value);
        $this->assertEquals('01.01.2015', $item->byEmployers[0]->startedAt->format('d.m.Y'));
        $this->assertEquals('20.05.2015', $item->byEmployers[0]->endedAt->format('d.m.Y'));
        $this->assertEquals(0, $item->byEmployers[0]->workTimeRecord->years);
        $this->assertEquals(4, $item->byEmployers[0]->workTimeRecord->months);
        $this->assertEquals(20, $item->byEmployers[0]->workTimeRecord->days);
        $this->assertEquals([1, 2], $item->byEmployers[0]->quarters);
        $this->assertTrue(BigDecimal::of('737813.22')->isEqualTo($item->byEmployers[0]->incomeSum));
        $this->assertTrue(BigDecimal::of('113760.00')->isEqualTo($item->byEmployers[0]->insurancePaymentsSum));

        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РОМАШКА"', trim($item->byEmployers[1]->name));
        $this->assertEquals('087-999-000007', $item->byEmployers[1]->sfrRegistrationNumber->value);
        $this->assertEquals('25.05.2015', $item->byEmployers[1]->startedAt->format('d.m.Y'));
        $this->assertEquals('31.12.2015', $item->byEmployers[1]->endedAt->format('d.m.Y'));
        $this->assertEquals(0, $item->byEmployers[1]->workTimeRecord->years);
        $this->assertEquals(6, $item->byEmployers[1]->workTimeRecord->months);
        $this->assertEquals(27, $item->byEmployers[1]->workTimeRecord->days);
        $this->assertEquals([2, 3, 4], $item->byEmployers[1]->quarters);
        $this->assertTrue(BigDecimal::of('958641.85')->isEqualTo($item->byEmployers[1]->incomeSum));
        $this->assertTrue(BigDecimal::of('113760.00')->isEqualTo($item->byEmployers[1]->insurancePaymentsSum));

        $item = $output->coefficientDataSince2015[count($output->coefficientDataSince2015) - 1];
        $this->assertTrue(Year::parse('2025')->isEqualTo($item->year));
        $this->assertTrue(BigDecimal::of('10.000')->isEqualTo($item->coefficient));

        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЗОЛОТОЙ ГУСЬ"', trim($item->byEmployers[0]->name));
        $this->assertEquals('087-999-000002', $item->byEmployers[0]->sfrRegistrationNumber->value);
        $this->assertEquals('01.01.2025', $item->byEmployers[0]->startedAt->format('d.m.Y'));
        $this->assertEquals('31.12.2025', $item->byEmployers[0]->endedAt->format('d.m.Y'));
        $this->assertEquals(1, $item->byEmployers[0]->workTimeRecord->years);
        $this->assertEquals(0, $item->byEmployers[0]->workTimeRecord->months);
        $this->assertEquals(0, $item->byEmployers[0]->workTimeRecord->days);
        $this->assertEquals([1, 2, 3, 4], $item->byEmployers[0]->quarters);
        $this->assertTrue(BigDecimal::of('4778599.62')->isEqualTo($item->byEmployers[0]->incomeSum));
        $this->assertTrue(BigDecimal::of('441991.81')->isEqualTo($item->byEmployers[0]->insurancePaymentsSum));

        $this->assertTrue(BigDecimal::of('0.00')->isEqualTo($output->coefficientCalculationUntil2002->averageMonthlyIncome));
        $this->assertEquals(0, $output->coefficientCalculationUntil2002->workTimeRecord->years);
        $this->assertEquals(0, $output->coefficientCalculationUntil2002->workTimeRecord->months);
        $this->assertEquals(0, $output->coefficientCalculationUntil2002->workTimeRecord->days);

        $this->assertTrue(BigDecimal::of('247318.56')->isEqualTo($output->coefficientCalculationUntil2015->insurancePaymentsSum));

        $item = $output->coefficientCalculationUntil2015->byEmployers[0];
        $this->assertEquals('ЦЕНТРАЛИЗОВАННАЯ БУХГАЛТЕРИЯ КОМИТЕТА ПО КОТИКАМ МОСКВЫ', $item->name);
        $this->assertEquals('087-999-000008', $item->sfrRegistrationNumber->value);
        $this->assertEquals('01.09.2005', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('31.12.2007', $item->endedAt->format('d.m.Y'));
        $this->assertTrue(BigDecimal::of('12507.90')->isEqualTo($item->insurancePaymentsSum));
        $this->assertEquals(2, $item->workTimeRecord->years);
        $this->assertEquals(4, $item->workTimeRecord->months);
        $this->assertEquals(0, $item->workTimeRecord->days);

        $item = $output->coefficientCalculationUntil2015->byEmployers[1];
        $this->assertEquals('ГОГОЛЬ НИКОЛАЙ ВАСИЛЬЕВИЧ', $item->name);
        $this->assertEquals('087-999-000006', $item->sfrRegistrationNumber->value);
        $this->assertEquals('15.03.2011', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('13.07.2011', $item->endedAt->format('d.m.Y'));
        $this->assertTrue(BigDecimal::of('4777.89')->isEqualTo($item->insurancePaymentsSum));
        $this->assertEquals(0, $item->workTimeRecord->years);
        $this->assertEquals(3, $item->workTimeRecord->months);
        $this->assertEquals(29, $item->workTimeRecord->days);

        $item = $output->coefficientCalculationUntil2015->byEmployers[2];
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ БЕГЕМОТ', $item->name);
        $this->assertEquals('087-999-000005', $item->sfrRegistrationNumber->value);
        $this->assertEquals('28.05.2012', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('31.12.2014', $item->endedAt->format('d.m.Y'));
        $this->assertTrue(BigDecimal::of('207840.00')->isEqualTo($item->insurancePaymentsSum));
        $this->assertEquals(2, $item->workTimeRecord->years);
        $this->assertEquals(7, $item->workTimeRecord->months);
        $this->assertEquals(4, $item->workTimeRecord->days);

        $this->assertInstanceOf(PensionPrivateFund::class, $output->privateFund);
        $this->assertEquals('АО НПФ ВОЗРАСТ ПРИХОДИТ ОДИН', $output->privateFund->name);
        $this->assertEquals('29.09.2012', $output->privateFund->since->format('d.m.Y'));

        $this->assertTrue(BigDecimal::of('72307.91')->isEqualTo($output->privateFund->account->mandatoryPensionInsurance));
        $this->assertTrue(BigDecimal::of('0.00')->isEqualTo($output->privateFund->account->maternityCapital));
        $this->assertTrue(BigDecimal::of('0.00')->isEqualTo($output->privateFund->account->additionalDepositions));
        $this->assertTrue(BigDecimal::of('72307.91')->isEqualTo($output->privateFund->account->total));

        $this->assertTrue(BigDecimal::of('170480.08')->isEqualTo($output->privateFund->savings->mandatoryPensionInsurance));
        $this->assertTrue(BigDecimal::of('0.00')->isEqualTo($output->privateFund->savings->maternityCapital));
        $this->assertTrue(BigDecimal::of('0.00')->isEqualTo($output->privateFund->savings->additionalDepositions));
        $this->assertTrue(BigDecimal::of('170480.08')->isEqualTo($output->privateFund->savings->total));

        $this->assertTrue(BigDecimal::of('0.0')->isEqualTo($output->privateFund->incomeSum));
        $this->assertTrue(BigDecimal::of('0.0')->isEqualTo($output->privateFund->deductionSum));
        $this->assertTrue(BigDecimal::of('0.0')->isEqualTo($output->privateFund->guaranteesRefundSum));
        $this->assertTrue(BigDecimal::of('0.0')->isEqualTo($output->privateFund->guaranteesCompensationSum));
    }
}
