<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

use Symfony\Component\Serializer\Annotation\SerializedPath;
use Symfony\Component\Uid\NilUuid;
use Symfony\Component\Uid\Uuid;

final readonly class Address
{
    /**
     * @param non-empty-string|null $city
     * @param non-empty-string|null $district
     * @param non-empty-string|null $area
     * @param non-empty-string|null $settlement
     * @param non-empty-string|null $additionArea
     * @param non-empty-string|null $additionAreaStreet
     * @param non-empty-string|null $street
     * @param non-empty-string|null $house
     * @param non-empty-string|null $frame
     * @param non-empty-string|null $flat
     * @param non-empty-string|null $room
     * @param non-empty-string|null $zipCode
     * @param non-empty-string|null $fiasCodeLevel
     * @param non-empty-string      $addressStr
     * @param non-empty-string|null $region
     */
    public function __construct(
        #[SerializedPath('[countryId]')]
        public CountryIso $countryIso,
        public string $addressStr,
        public ?string $region,
        public ?string $city,
        public ?string $district,
        public ?string $area,
        public ?string $settlement,
        public ?string $additionArea,
        public ?string $additionAreaStreet,
        public ?string $street,
        public ?string $house,
        public ?string $frame,
        public ?string $flat,
        public ?string $room,
        public ?string $zipCode,
        public ?string $fiasCodeLevel,
        public Uuid $fiasCode = new NilUuid(),
    ) {
    }
}
