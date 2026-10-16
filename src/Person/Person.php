<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Document\InnNumber;
use Vanta\Integration\Esia\Struct\Document\SnilsNumber;
use Vanta\Integration\Esia\Struct\Gender;
use Vanta\Integration\Esia\Struct\Person\Contact\Contact;
use Vanta\Integration\Esia\Struct\Person\Document\PersonDocument;

/**
 * Персональные данные пользователя ЕСИА: документ REST API ЕСИА `prns/{oid}` с вложенными
 * `contacts`, `addresses`, `documents` (`embed`), в формате JSON как есть.
 *
 * Состав зависит от `scope`, запрошенного при авторизации: любое поле может отсутствовать
 * (`null`, коллекции — `[]`). Пол — только `M` / `F`: другое значение не разбирается.
 *
 * Это персональные данные: не логируйте их.
 */
final readonly class Person
{
    /**
     * @param non-empty-string|null  $firstName    имя
     * @param non-empty-string|null  $lastName     фамилия
     * @param non-empty-string|null  $middleName   отчество (отсутствует, если его нет в документе)
     * @param DateTimeImmutable|null $birthDate    дата рождения (ДД.ММ.ГГГГ, время 00:00:00)
     * @param non-empty-string|null  $birthPlace   место рождения
     * @param Gender|null            $gender       пол
     * @param non-empty-string|null  $citizenship  гражданство (трёхбуквенный код ОКСМ, напр. «RUS»)
     * @param SnilsNumber|null       $snils        СНИЛС
     * @param InnNumber|null         $inn          ИНН
     * @param bool|null              $trusted      учётная запись подтверждена
     * @param bool|null              $verifying    данные в процессе проверки
     * @param AccountStatus|null     $status       статус учётной записи
     * @param DateTimeImmutable|null $updatedOn    дата последнего изменения персональных данных УЗ
     * @param SelfEmployed|null      $selfEmployed информация о самозанятом
     * @param list<Contact>          $contacts     контакты
     * @param list<Address>          $addresses    адреса
     * @param list<PersonDocument>   $documents    документы
     */
    public function __construct(
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $middleName = null,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => '!d.m.Y'])]
        public ?DateTimeImmutable $birthDate = null,
        public ?string $birthPlace = null,
        public ?Gender $gender = null,
        public ?string $citizenship = null,
        public ?SnilsNumber $snils = null,
        public ?InnNumber $inn = null,
        public ?bool $trusted = null,
        public ?bool $verifying = null,
        public ?AccountStatus $status = null,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'U'])]
        public ?DateTimeImmutable $updatedOn = null,
        public ?SelfEmployed $selfEmployed = null,
        #[SerializedPath('[contacts][elements]')]
        public array $contacts = [],
        #[SerializedPath('[addresses][elements]')]
        public array $addresses = [],
        #[SerializedPath('[documents][elements]')]
        public array $documents = [],
    ) {
    }
}
