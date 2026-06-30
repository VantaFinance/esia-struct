<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\Mvd\PreviousDocumentV2;
use Vanta\Integration\Esia\Struct\Document\Mvd\PreviousRussianInternationalPassportV2;
use Vanta\Integration\Esia\Struct\Document\Mvd\PreviousRussianPassportStatus;
use Vanta\Integration\Esia\Struct\Document\Mvd\PreviousRussianPassportV2;

final class PassportHistoryV2FileTest extends BaseTestCase
{
    public function testValid(): void
    {
        $contents = $this->getFixture('passport_history.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parsePassportHistoryV2File($contents);
        $this->assertIsList($output);
        $this->assertCount(3, $output);
        $this->assertContainsOnlyInstancesOf(PreviousDocumentV2::class, $output);

        $this->assertInstanceOf(PreviousRussianInternationalPassportV2::class, $output[0]);
        $this->assertSame(DocumentType::RUSSIAN_INTERNATIONAL_PASSPORT, $output[0]->type);
        $this->assertSame('77', $output[0]->series->value);
        $this->assertSame('1234567', $output[0]->number->value);
        $this->assertSame('06.03.2024', $output[0]->issuedAt->format('d.m.Y'));
        $this->assertSame('МВД 77705', $output[0]->issuedBy);
        $this->assertSame(PreviousRussianPassportStatus::VALID, $output[0]->status);

        $this->assertInstanceOf(PreviousRussianPassportV2::class, $output[1]);
        $this->assertSame(DocumentType::RUSSIAN_PASSPORT, $output[1]->type);
        $this->assertSame('4515', $output[1]->series->value);
        $this->assertSame('451500', $output[1]->number->value);
        $this->assertSame('06.03.2015', $output[1]->issuedAt->format('d.m.Y'));
        $this->assertSame('770011', $output[1]->divisionCode?->value);
        $this->assertSame(PreviousRussianPassportStatus::VALID, $output[1]->status);

        $this->assertInstanceOf(PreviousRussianPassportV2::class, $output[2]);
        $this->assertSame(PreviousRussianPassportStatus::NO_INFORMATION, $output[2]->status);
    }

    public function testSingleItem(): void
    {
        $contents = $this->getFixture('passport_history.single.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parsePassportHistoryV2File($contents);

        $this->assertIsList($output);
        $this->assertCount(1, $output);
        $this->assertInstanceOf(PreviousRussianPassportV2::class, $output[0]);
        $this->assertSame('4515', $output[0]->series->value);
    }
}
