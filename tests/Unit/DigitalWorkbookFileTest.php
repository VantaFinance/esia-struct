<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorFromClassMetadata;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\UidNormalizer;
use Symfony\Component\Serializer\Serializer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DateTimeUnixTimeNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\DiscriminatorDefaultNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\InnNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\KppNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\SfrRegistrationNumberNormalizer;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\UidFailedNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbook;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookAwardEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookContinuousExclusionEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookContinuousRestorationEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookCorrectionEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookDismissalEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookEducationEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookEstablishmentEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookEventType;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookHiringEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookMilitaryServiceEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookProhibitionEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookReassignmentEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookRenamingEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookResumptionEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookStatus;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookSuspensionEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookTrainingEvent;
use Vanta\Integration\Esia\Struct\Document\Sfr\DigitalWorkbookUnknownEvent;
use Vanta\Integration\Esia\Struct\Document\UnknownDocument;

final class DigitalWorkbookFileTest extends BaseTestCase
{
    public function testValid(): void
    {
        $output = $this->deserialize('digital_workbook.valid.json');

        $this->assertInstanceOf(DigitalWorkbook::class, $output);
        $this->assertSame(DocumentType::DIGITAL_WORKBOOK, $output->type);
        $this->assertSame('1000000001', $output->oid);
        $this->assertSame(DigitalWorkbookStatus::SUCCESS, $output->documentStatus);
        $this->assertSame('2026-01-01', $output->createdAt?->format('Y-m-d'));
        $this->assertSame('15.03.2021', $output->statement?->providedAt?->format('d.m.Y'));
        $this->assertNull($output->statement?->continuedAt);
        $this->assertSame('01.01.2026', $output->formedAt?->format('d.m.Y'));
        $this->assertCount(7, $output->events);

        $hiring = $output->events[0];
        $this->assertInstanceOf(DigitalWorkbookHiringEvent::class, $hiring);
        $this->assertSame(DigitalWorkbookEventType::HIRING, $hiring->type);
        $this->assertSame('01.02.2022', $hiring->occurredAt->format('d.m.Y'));
        $this->assertSame('Инженер', $hiring->position);
        $this->assertSame('Отдел разработки', $hiring->division);
        $this->assertSame('2512.1', $hiring->functionType);
        $this->assertSame('1234567890', $hiring->employer?->inn?->value);
        $this->assertSame('000-000-000001', $hiring->employer?->sfrRegistrationNumber?->value);
        $this->assertNull($hiring->employer?->kpp);
        $this->assertFalse($hiring->isPartTime);

        $reassignment = $output->events[1];
        $this->assertInstanceOf(DigitalWorkbookReassignmentEvent::class, $reassignment);
        $this->assertSame(DigitalWorkbookEventType::REASSIGNMENT, $reassignment->type);
        $this->assertSame('123401001', $reassignment->employer?->kpp?->value);

        $dismissal = $output->events[2];
        $this->assertInstanceOf(DigitalWorkbookDismissalEvent::class, $dismissal);
        $this->assertSame(DigitalWorkbookEventType::DISMISSAL, $dismissal->type);
        $this->assertSame('ТК РФ', $dismissal->dismissalBasis?->type);
        $this->assertSame('77', $dismissal->dismissalBasis?->basisItem);
        $this->assertSame('1', $dismissal->dismissalBasis?->basisPart);
        $this->assertSame('3', $dismissal->dismissalBasis?->basisParagraph);
        $this->assertSame('Расторжение трудового договора по инициативе работника', $dismissal->reason);

        $award = $output->events[3];
        $this->assertInstanceOf(DigitalWorkbookAwardEvent::class, $award);
        $this->assertSame(DigitalWorkbookEventType::AWARD, $award->type);
        $this->assertSame('Награждение (Поощрение)', $award->typeName);

        $future = $output->events[4];
        $this->assertInstanceOf(DigitalWorkbookUnknownEvent::class, $future);
        $this->assertSame('Новый вид', $future->typeName);

        $partTime = $output->events[5];
        $this->assertInstanceOf(DigitalWorkbookHiringEvent::class, $partTime);
        $this->assertTrue($partTime->isPartTime);

        $twoReasons = $output->events[6];
        $this->assertCount(2, $twoReasons->reasons);
        $this->assertSame('7', $twoReasons->reasons[0]->number);
        $this->assertSame('14.10.2021', $twoReasons->reasons[0]->date->format('d.m.Y'));
        $this->assertSame('ДС', $twoReasons->reasons[1]->series);

        $this->assertCount(1, $output->laborActivities);
        $this->assertSame('ООО "ВАСИЛЁК"', $output->laborActivities[0]->name);
        $this->assertSame('01.09.2015', $output->laborActivities[0]->startedAt->format('d.m.Y'));
        $this->assertSame('31.08.2019', $output->laborActivities[0]->endedAt->format('d.m.Y'));
    }

    public function testValidMinimal(): void
    {
        $output = $this->deserialize('digital_workbook.valid.minimal.json');

        $this->assertInstanceOf(DigitalWorkbook::class, $output);
        $this->assertSame(DigitalWorkbookStatus::NO_DATA, $output->documentStatus);
        $this->assertNull($output->createdAt);
        $this->assertNull($output->statement);
        $this->assertNull($output->formedAt);
        $this->assertSame([], $output->events);
        $this->assertSame([], $output->laborActivities);
    }

    /**
     * @param class-string<DigitalWorkbookEvent> $class
     */
    #[DataProvider('provideEventKinds')]
    public function testEventKind(int $index, string $class, DigitalWorkbookEventType $type): void
    {
        $output = $this->deserialize('digital_workbook.valid.all_events.json');

        $this->assertInstanceOf(DigitalWorkbook::class, $output);
        $this->assertCount(16, $output->events);
        $this->assertInstanceOf($class, $output->events[$index]);
        $this->assertSame($type, $output->events[$index]->type);
    }

    /**
     * @return iterable<string, array{int, class-string<DigitalWorkbookEvent>, DigitalWorkbookEventType}>
     */
    public static function provideEventKinds(): iterable
    {
        yield '1 hiring' => [0, DigitalWorkbookHiringEvent::class, DigitalWorkbookEventType::HIRING];
        yield '2 reassignment' => [1, DigitalWorkbookReassignmentEvent::class, DigitalWorkbookEventType::REASSIGNMENT];
        yield '3 renaming' => [2, DigitalWorkbookRenamingEvent::class, DigitalWorkbookEventType::RENAMING];
        yield '4 establishment' => [3, DigitalWorkbookEstablishmentEvent::class, DigitalWorkbookEventType::ESTABLISHMENT];
        yield '5 dismissal' => [4, DigitalWorkbookDismissalEvent::class, DigitalWorkbookEventType::DISMISSAL];
        yield '6 prohibition' => [5, DigitalWorkbookProhibitionEvent::class, DigitalWorkbookEventType::PROHIBITION];
        yield '7 suspension' => [6, DigitalWorkbookSuspensionEvent::class, DigitalWorkbookEventType::SUSPENSION];
        yield '8 resumption' => [7, DigitalWorkbookResumptionEvent::class, DigitalWorkbookEventType::RESUMPTION];
        yield '11 military service' => [8, DigitalWorkbookMilitaryServiceEvent::class, DigitalWorkbookEventType::MILITARY_SERVICE];
        yield '12 education' => [9, DigitalWorkbookEducationEvent::class, DigitalWorkbookEventType::EDUCATION];
        yield '13 training' => [10, DigitalWorkbookTrainingEvent::class, DigitalWorkbookEventType::TRAINING];
        yield '14 award' => [11, DigitalWorkbookAwardEvent::class, DigitalWorkbookEventType::AWARD];
        yield '15 continuous exclusion' => [12, DigitalWorkbookContinuousExclusionEvent::class, DigitalWorkbookEventType::CONTINUOUS_EXCLUSION];
        yield '16 continuous restoration' => [13, DigitalWorkbookContinuousRestorationEvent::class, DigitalWorkbookEventType::CONTINUOUS_RESTORATION];
        yield '17 correction' => [14, DigitalWorkbookCorrectionEvent::class, DigitalWorkbookEventType::CORRECTION];
        yield '18 unknown' => [15, DigitalWorkbookUnknownEvent::class, DigitalWorkbookEventType::UNKNOWN];
    }

    public function testPeriodDates(): void
    {
        $output = $this->deserialize('digital_workbook.valid.all_events.json');

        $this->assertInstanceOf(DigitalWorkbook::class, $output);

        $militaryService = $output->events[8];
        $this->assertInstanceOf(DigitalWorkbookMilitaryServiceEvent::class, $militaryService);
        $this->assertSame('01.06.2010', $militaryService->startedAt?->format('d.m.Y'));
        $this->assertSame('01.06.2011', $militaryService->endedAt?->format('d.m.Y'));

        $suspension = $output->events[6];
        $this->assertInstanceOf(DigitalWorkbookSuspensionEvent::class, $suspension);
        $this->assertNull($suspension->startedAt);
        $this->assertNull($suspension->endedAt);
    }

    #[DataProvider('provideInvalid')]
    public function testInvalidFallsBackToUnknownDocument(string $fixture): void
    {
        $this->assertInstanceOf(UnknownDocument::class, $this->deserialize($fixture));
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideInvalid(): iterable
    {
        yield 'bad statusDoc' => ['digital_workbook.invalid.bad_status.json'];
        yield 'missing oid' => ['digital_workbook.invalid.missing_oid.json'];
    }

    private function deserialize(string $fixture): Document
    {
        $document = self::createSerializer()->deserialize($this->getFixture($fixture), Document::class, 'json');

        $this->assertInstanceOf(Document::class, $document);

        return $document;
    }

    /**
     * Consumer-side JSON serializer: the subset of DocumentParser::create() normalizers this document needs, with JsonEncoder.
     */
    private static function createSerializer(): Serializer
    {
        $classMetadataFactory = new ClassMetadataFactory(new AttributeLoader());
        $objectNormalizer     = new ObjectNormalizer(
            $classMetadataFactory,
            new MetadataAwareNameConverter($classMetadataFactory),
            null,
            new PropertyInfoExtractor([], [new PhpStanExtractor()], [], [], []),
            new ClassDiscriminatorFromClassMetadata($classMetadataFactory),
        );

        return new Serializer(
            [
                new BackedEnumNormalizer(),
                new UidFailedNormalizer(new UidNormalizer()),
                new InnNumberNormalizer(),
                new SfrRegistrationNumberNormalizer(),
                new KppNumberNormalizer(),
                new DateTimeUnixTimeNormalizer(new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => 'd.M.Y'])),
                new DiscriminatorDefaultNormalizer($objectNormalizer, $classMetadataFactory),
                new ArrayDenormalizer(),
            ],
            [new JsonEncoder()],
        );
    }
}
