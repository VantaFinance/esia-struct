<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;

final class PayoutIncomeFileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     * @throws MathException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('payout_income.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parsePayoutIncomeFile($contents);

        $this->assertEquals('VO_DOHFLSV_20260420_dd4ecec0-81ed-416d-97d5-d88a0dcd7b00', $output->id);
        $this->assertEquals('4.01', $output->versionForm);
        $this->assertEquals(1, $output->countDocuments);

        $this->assertEquals('dd4ecec0-81ed-416d-97d5-d88a0dcd7b00', $output->document->id);
        $this->assertEquals('01.04.1989', $output->document->birthAt->format('d.m.Y'));
        $this->assertEquals('123-456-789 00', $output->document->snils->value);
        $this->assertEquals('771234567890', $output->document->innNumber->value);

        $this->assertEquals(2026, $output->document->payoutYears[0]->year->getValue());
        $this->assertEquals('7787654321', $output->document->payoutYears[0]->organization?->inn->value);
        $this->assertNull($output->document->payoutYears[0]->organization?->kpp);
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РОГА И КОПЫТА"', $output->document->payoutYears[0]->organization?->name);

        $amounts = array_map(
            static fn ($item) => [
                'month' => $item['month'],
                'sum'   => BigDecimal::of($item['sum']),
            ],
            [
                ['month' => 1, 'sum' => '402299'],
                ['month' => 2, 'sum' => '402299'],
            ],
        );

        foreach ($output->document->payoutYears[0]->payouts as $index => $payout) {
            $this->assertEquals($amounts[$index]['month'], $payout->month->getValue());
            $this->assertTrue($payout->sum->isEqualTo($amounts[$index]['sum']));
        }

        $this->assertEquals(2025, $output->document->payoutYears[1]->year->getValue());
        $this->assertEquals('7712345678', $output->document->payoutYears[1]->organization?->inn->value);
        $this->assertEquals('772201001', $output->document->payoutYears[1]->organization?->kpp?->value);
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "ЗОЛОТОЙ ГУСЬ"', $output->document->payoutYears[1]->organization?->name);

        $amounts = array_map(
            static fn ($item) => [
                'month' => $item['month'],
                'sum'   => BigDecimal::of($item['sum']),
            ],
            [
                ['month' => 1,  'sum' => '372088.8'],
                ['month' => 2,  'sum' => '402299'],
                ['month' => 3,  'sum' => '402299'],
                ['month' => 4,  'sum' => '442792.37'],
                ['month' => 5,  'sum' => '335249.16'],
                ['month' => 6,  'sum' => '402299'],
                ['month' => 7,  'sum' => '416688.79'],
                ['month' => 8,  'sum' => '402299'],
                ['month' => 9,  'sum' => '402299'],
                ['month' => 10, 'sum' => '416861.13'],
                ['month' => 11, 'sum' => '381125.37'],
                ['month' => 12, 'sum' => '402299'],
            ],
        );

        foreach ($output->document->payoutYears[1]->payouts as $index => $payout) {
            $this->assertEquals($amounts[$index]['month'], $payout->month->getValue());
            $this->assertTrue($payout->sum->isEqualTo($amounts[$index]['sum']));
        }
    }
}
