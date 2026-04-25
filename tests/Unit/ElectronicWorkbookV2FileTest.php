<?php

/**
 * ESIA Struct
 *
 * @author Valentin Nazarov <v.nazarov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use Symfony\Component\Serializer\Exception\ExceptionInterface as SerializerException;
use Vanta\Integration\Esia\Struct\Bridge\Document\DocumentParser;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbookV2DismissalEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbookV2EventType;
use Vanta\Integration\Esia\Struct\Document\Sfr\ElectronicWorkbookV2HiringEvent;

final class ElectronicWorkbookV2FileTest extends BaseTestCase
{
    /**
     * @throws SerializerException
     */
    public function testValid(): void
    {
        $contents = $this->getFixture('electronic_workbook.valid.xml');
        $parser   = DocumentParser::create();
        $output   = $parser->parseElectronicWorkbookV2File($contents);

        $this->assertEquals(DocumentType::ELECTRONIC_WORKBOOK_V2, $output->type);

        $this->assertEquals('БАШМАЧКИН', $output->person->lastName);
        $this->assertEquals('АКАКИЙ', $output->person->firstName);
        $this->assertEquals('АКАКИЕВИЧ', $output->person->middleName);
        $this->assertEquals('123-456-789 00', $output->person->snils->value);
        $this->assertEquals('01.04.1989', $output->person->birthAt->format('d.m.Y'));

        $item = $output->history[0];
        $this->assertEquals('ЦЕНТРАЛИЗОВАННАЯ БУХГАЛТЕРИЯ КОМИТЕТА ПО КОТИКАМ МОСКВЫ', trim($item->employerName));
        $this->assertEquals('087-999-000004', $item->employerRegistrationNumber->value);
        $this->assertEquals('01.09.2005', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('31.12.2007', $item->endedAt?->format('d.m.Y'));

        $item = $output->history[1];
        $this->assertEquals('ГОГОЛЬ НИКОЛАЙ ВАСИЛЬЕВИЧ', trim($item->employerName));
        $this->assertEquals('087-999-000005', $item->employerRegistrationNumber->value);
        $this->assertEquals('15.03.2011', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('13.07.2011', $item->endedAt?->format('d.m.Y'));

        $item = $output->history[2];
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ БЕГЕМОТ', trim($item->employerName));
        $this->assertEquals('087-999-000006', $item->employerRegistrationNumber->value);
        $this->assertEquals('28.05.2012', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('20.05.2015', $item->endedAt?->format('d.m.Y'));

        $item = $output->history[3];
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РОМАШКА"', trim($item->employerName));
        $this->assertEquals('087-999-000007', $item->employerRegistrationNumber->value);
        $this->assertEquals('25.05.2015', $item->startedAt->format('d.m.Y'));
        $this->assertEquals('29.01.2016', $item->endedAt?->format('d.m.Y'));

        $item = $output->events[0];
        $this->assertInstanceOf(ElectronicWorkbookV2HiringEvent::class, $item);
        $this->assertEquals(ElectronicWorkbookV2EventType::HIRING, $item->type);
        $this->assertEquals('24.11.2020', $item->occurredAt->format('d.m.Y'));
        $this->assertEquals('Менеджер команды слонов', $item->position);
        $this->assertTrue($item->isPartTime);
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "АБВГД"', trim($item->employer->name));
        $this->assertEquals('9705000001', $item->employer->inn->value);
        $this->assertEquals('771000001', $item->employer->kpp?->value);
        $this->assertEquals('087-999-000001', $item->employer->sfrRegistrationNumber->value);

        $item = $output->events[1];
        $this->assertInstanceOf(ElectronicWorkbookV2DismissalEvent::class, $item);
        $this->assertEquals(ElectronicWorkbookV2EventType::DISMISSAL, $item->type);
        $this->assertEquals('17.11.2021', $item->occurredAt->format('d.m.Y'));
        $this->assertEquals('Трудовой договор расторгнут по инициативе работника', $item->reason);
        $this->assertTrue($item->isPartTime);
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "АБВГД"', trim($item->employer->name));
        $this->assertEquals('9705000001', $item->employer->inn->value);
        $this->assertEquals('771000001', $item->employer->kpp?->value);
        $this->assertEquals('087-999-000001', $item->employer->sfrRegistrationNumber->value);

        $item = $output->events[2];
        $this->assertInstanceOf(ElectronicWorkbookV2HiringEvent::class, $item);
        $this->assertEquals(ElectronicWorkbookV2EventType::HIRING, $item->type);
        $this->assertEquals('18.11.2021', $item->occurredAt->format('d.m.Y'));
        $this->assertEquals('Менеджер команды слонов', $item->position);
        $this->assertFalse($item->isPartTime);
        $this->assertEquals('ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РОГА И КОПЫТА"', trim($item->employer->name));
        $this->assertEquals('9705000002', $item->employer->inn->value);
        $this->assertNull($item->employer->kpp);
        $this->assertEquals('087-999-000002', $item->employer->sfrRegistrationNumber->value);

        $item = $output->events[3];
        $this->assertInstanceOf(ElectronicWorkbookV2DismissalEvent::class, $item);
        $this->assertEquals(ElectronicWorkbookV2EventType::DISMISSAL, $item->type);
        $this->assertEquals('09.06.2023', $item->occurredAt->format('d.m.Y'));
        $this->assertEquals('Расторжение трудового договора по инициативе работника', $item->reason);
        $this->assertFalse($item->isPartTime);
        $this->assertEquals('ООО "РОГА И КОПЫТА"', trim($item->employer->name));
        $this->assertEquals('9705000002', $item->employer->inn->value);
        $this->assertNull($item->employer->kpp);
        $this->assertEquals('087-999-000002', $item->employer->sfrRegistrationNumber->value);

        $item = $output->events[4];
        $this->assertInstanceOf(ElectronicWorkbookV2HiringEvent::class, $item);
        $this->assertEquals(ElectronicWorkbookV2EventType::HIRING, $item->type);
        $this->assertEquals('13.06.2023', $item->occurredAt->format('d.m.Y'));
        $this->assertEquals('Ведущий HTML разработчик', $item->position);
        $this->assertFalse($item->isPartTime);
        $this->assertEquals('ООО "ЗОЛОТОЙ ГУСЬ"', trim($item->employer->name));
        $this->assertEquals('9705000003', $item->employer->inn->value);
        $this->assertEquals('771000003', $item->employer->kpp?->value);
        $this->assertEquals('087-999-000003', $item->employer->sfrRegistrationNumber->value);
    }
}
