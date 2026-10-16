<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Person;

use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer as ObjectNormalizer;
use Vanta\Integration\Esia\Struct\CountryIso;

/**
 * Адрес пользователя (элемент `addresses`). Заполнены не все поля: состав зависит от адреса.
 */
final readonly class Address
{
    /**
     * @param AddressType           $type               тип адреса
     * @param CountryIso|null       $countryIso         страна (ISO 3166-1 alpha-3) из `countryId`
     * @param non-empty-string|null $addressStr         адрес одной строкой
     * @param numeric-string|null   $id                 идентификатор адреса в ЕСИА
     * @param non-empty-string|null $zipCode            почтовый индекс
     * @param non-empty-string|null $countryId          идентификатор страны
     * @param non-empty-string|null $region             регион
     * @param non-empty-string|null $city               город
     * @param non-empty-string|null $district           внутригородской район
     * @param non-empty-string|null $area               район
     * @param non-empty-string|null $settlement         поселение
     * @param non-empty-string|null $street             улица
     * @param non-empty-string|null $house              дом
     * @param non-empty-string|null $building           строение
     * @param non-empty-string|null $frame              корпус
     * @param non-empty-string|null $frameType          тип дополнительной части дома («к» — корпус; литера)
     * @param non-empty-string|null $flat               квартира
     * @param non-empty-string|null $room               номер помещения внутри помещения (комнаты)
     * @param non-empty-string|null $fiasCode           код КЛАДР / ФИАС
     * @param non-empty-string|null $fiasCodeLevel      уровень ФИАС-кода
     * @param non-empty-string|null $additionArea       дополнительная территория
     * @param non-empty-string|null $additionAreaStreet улица на дополнительной территории
     */
    public function __construct(
        public AddressType $type,
        #[SerializedPath('[countryId]')]
        public ?CountryIso $countryIso = null,
        public ?string $addressStr = null,
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public ?string $id = null,
        public ?string $zipCode = null,
        public ?string $countryId = null,
        public ?string $region = null,
        public ?string $city = null,
        public ?string $district = null,
        public ?string $area = null,
        public ?string $settlement = null,
        public ?string $street = null,
        public ?string $house = null,
        public ?string $building = null,
        public ?string $frame = null,
        public ?string $frameType = null,
        public ?string $flat = null,
        public ?string $room = null,
        public ?string $fiasCode = null,
        public ?string $fiasCodeLevel = null,
        public ?string $additionArea = null,
        public ?string $additionAreaStreet = null,
    ) {
    }
}
