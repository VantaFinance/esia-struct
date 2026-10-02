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
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Vanta\Integration\Esia\Struct\Bridge\Serializer\Normalizer\LazyDocumentNormalizer;
use Vanta\Integration\Esia\Struct\Document\Document;
use Vanta\Integration\Esia\Struct\Document\DocumentType;
use Vanta\Integration\Esia\Struct\Document\LazyDocument;
use Vanta\Integration\Esia\Struct\Document\LazyIncomeReference;

final class LazyDocumentNormalizerTest extends BaseTestCase
{
    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideSupports')]
    public function testSupports(array $data, bool $expected): void
    {
        $this->assertSame($expected, (new LazyDocumentNormalizer())->supportsDenormalization($data, Document::class, 'json'));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, bool}>
     */
    public static function provideSupports(): iterable
    {
        yield 'search without requestId' => [['oid' => '1002414864', 'statusDoc' => 'SEARCH'], true];
        yield 'search with requestId' => [['oid' => '1014950897', 'requestId' => 'ec9818f1-8123-4ec9-b8c4-2530ae352d3e', 'statusDoc' => 'SEARCH'], true];
        yield 'requestId only' => [['oid' => '1014950897', 'requestId' => 'ec9818f1-8123-4ec9-b8c4-2530ae352d3e'], true];
        yield 'requestId with year' => [['oid' => '1014950897', 'requestId' => 'ec9818f1-8123-4ec9-b8c4-2530ae352d3e', 'year' => '2024'], true];
        yield 'search without oid' => [['statusDoc' => 'SEARCH'], true];
        yield 'no consent short response' => [['oid' => '1014950897', 'type' => 'digital_workbook', 'statusDoc' => 'NO_CONSENT'], false];
        yield 'full document' => [['id' => '0f8b6d2e-1c4a-4e7b-9a3d-5b2c8e1f4a74', 'oid' => '1000000001', 'type' => 'DIGITAL_WORKBOOK', 'statusDoc' => 'SUCCESS'], false];
    }

    public function testSearchWithoutRequestId(): void
    {
        $output = (new LazyDocumentNormalizer())->denormalize(
            ['oid' => '1002414864', 'statusDoc' => 'SEARCH'],
            Document::class,
            'json',
            [LazyDocumentNormalizer::TYPE_DOCUMENT => DocumentType::DIGITAL_WORKBOOK],
        );

        $this->assertInstanceOf(LazyDocument::class, $output);
        $this->assertSame('1002414864', $output->oid);
        $this->assertSame(LazyDocumentNormalizer::REQUEST_ID_PLACEHOLDER, $output->requestId);
        $this->assertSame(DocumentType::DIGITAL_WORKBOOK, $output->type);
    }

    public function testSearchWithRequestIdKeepsIt(): void
    {
        $output = (new LazyDocumentNormalizer())->denormalize(
            ['oid' => '1014950897', 'requestId' => 'ec9818f1-8123-4ec9-b8c4-2530ae352d3e', 'statusDoc' => 'SEARCH'],
            Document::class,
            'json',
            [LazyDocumentNormalizer::TYPE_DOCUMENT => DocumentType::DIGITAL_WORKBOOK],
        );

        $this->assertInstanceOf(LazyDocument::class, $output);
        $this->assertSame('ec9818f1-8123-4ec9-b8c4-2530ae352d3e', $output->requestId);
    }

    public function testWithoutContextTypeIsUnknown(): void
    {
        $output = (new LazyDocumentNormalizer())->denormalize(['oid' => '1002414864', 'statusDoc' => 'SEARCH'], Document::class, 'json');

        $this->assertInstanceOf(LazyDocument::class, $output);
        $this->assertSame(DocumentType::UNKNOWN, $output->type);
    }

    public function testYearStillReturnsLazyIncomeReference(): void
    {
        $output = (new LazyDocumentNormalizer())->denormalize(
            ['oid' => '1014950897', 'requestId' => 'ec9818f1-8123-4ec9-b8c4-2530ae352d3e', 'year' => '2024'],
            Document::class,
            'json',
        );

        $this->assertInstanceOf(LazyIncomeReference::class, $output);
        $this->assertSame('ec9818f1-8123-4ec9-b8c4-2530ae352d3e', $output->requestId);
    }

    public function testSearchWithoutOidThrows(): void
    {
        $this->expectException(NotNormalizableValueException::class);

        (new LazyDocumentNormalizer())->denormalize(['statusDoc' => 'SEARCH'], Document::class, 'json');
    }
}
