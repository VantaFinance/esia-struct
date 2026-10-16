<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2026, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Grant;

use DateTimeImmutable;
use Symfony\Component\Serializer\Attribute\Context;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Serializer\Attribute\SerializedPath;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer as ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Vanta\Integration\Esia\Struct\Sysname;

/**
 * Согласие, выданное пользователем (элемент списка согласий ЕСИА), в том виде, в каком его прислала ЕСИА.
 *
 * Обязательны только поля, которые ЕСИА присылает всегда; остальные ЕСИА может не прислать (`null`, коллекции — `[]`).
 */
final readonly class GrantedPermission
{
    /**
     * @param numeric-string          $id                идентификатор согласия
     * @param Sysname                 $sysname           тип согласия; {@see Sysname::UNKNOWN}, если его нет в каталоге
     * @param string                  $rawSysname        тип согласия, как его прислала ЕСИА
     * @param non-empty-string        $name              название согласия
     * @param DateTimeImmutable       $issuedOn          дата выдачи
     * @param DateTimeImmutable       $expiredOn         дата окончания действия
     * @param GrantedPermissionStatus $status            статус согласия
     * @param list<GrantedScope>      $scopes            разрешённые данные
     * @param list<GrantedPurpose>    $purposes          цели обработки
     * @param list<GrantedAction>     $actions           разрешённые действия
     * @param numeric-string|null     $personId
     * @param numeric-string|null     $subjOid
     * @param numeric-string|null     $orgId
     * @param non-empty-string|null   $description
     * @param non-empty-string|null   $orgShortName
     * @param non-empty-string|null   $ogrn
     * @param non-empty-string|null   $orgAddress
     * @param non-empty-string|null   $responsibleObject
     */
    public function __construct(
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public string $id,
        #[SerializedPath('[sysname]')]
        public Sysname $sysname,
        #[SerializedName('sysname')]
        public string $rawSysname,
        public string $name,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'U'])]
        public DateTimeImmutable $issuedOn,
        #[Context(denormalizationContext: [DateTimeNormalizer::FORMAT_KEY => 'U'])]
        public DateTimeImmutable $expiredOn,
        public GrantedPermissionStatus $status,
        #[SerializedPath('[scopes][elements]')]
        public array $scopes = [],
        #[SerializedPath('[purposes][elements]')]
        public array $purposes = [],
        #[SerializedPath('[actions][elements]')]
        public array $actions = [],
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public ?string $personId = null,
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public ?string $subjOid = null,
        #[Context(denormalizationContext: [ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true])]
        public ?string $orgId = null,
        public ?int $permissionId = null,
        public ?string $description = null,
        public ?string $orgShortName = null,
        public ?string $ogrn = null,
        public ?string $orgAddress = null,
        public ?SignatureStatus $signatureStatus = null,
        public ?string $responsibleObject = null,
    ) {
    }
}
