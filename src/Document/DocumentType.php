<?php

/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct\Document;

enum DocumentType: string
{
    case UNKNOWN                          = 'UNKNOWN';
    case RUSSIAN_INTERNATIONAL_PASSPORT   = 'FRGN_PASS';
    case RUSSIAN_PASSPORT                 = 'RF_PASSPORT';
    case RUSSIAN_PASSPORT_V2              = 'RF_PASSPORT_V2';
    case SOVIET_PASSPORT                  = 'USSR_PASSPORT';
    case PASSPORT_HISTORY                 = 'PASSPORT_HISTORY';
    case RUSSIAN_DRIVER_LICENSE           = 'RF_DRIVING_LICENSE';
    case PAYOUT_INCOME                    = 'PAYOUT_INCOME';
    case INCOME_REFERENCE                 = 'INCOME_REFERENCE';
    case ELECTRONIC_WORKBOOK              = 'ELECTRONIC_WORKBOOK';
    case ILS_PFR                          = 'ILS_PFR';
    case PAYOUT_INCOME_V2                 = 'PAYOUT_INCOME_V2';
    case INCOME_REFERENCE_V2              = 'INCOME_REFERENCE_V2';
    case ELECTRONIC_WORKBOOK_V2           = 'ELECTRONIC_WORKBOOK_V2';
    case ELECTRONIC_WORKBOOK_V3           = 'ELECTRONIC_WORKBOOK_V3';
    case ILS_PFR_V2                       = 'ILS_PFR_V2';
    case FOREIGN_CITIZEN_DOCUMENT         = 'FID_DOC';
    case FOREIGN_BIRTH_CERTIFICATE        = 'FID_BRTH_CERT';
    case SOVIET_BIRTH_CERTIFICATE         = 'OLD_BRTH_CERT';
    case RUSSIAN_BIRTH_CERTIFICATE        = 'RF_BRTH_CERT';
    case MARRIAGE_CERTIFICATE             = 'MARRIED_CERT';
    case DIVORCE_CERTIFICATE              = 'DIVORCE_CERT';
    case NAME_CHANGE_CERTIFICATE          = 'NAME_CHANGE_CERT';
    case PATERNITY_CERTIFICATE            = 'FATHERHOOD_CERT';
    case ILS_SFR                          = 'ILS_SFR';
    case PENSION_REFERENCE                = 'PENSION_REFERENCE';
    case PENSION                          = 'PENSION';
    case PAYMENTS_EGISSO                  = 'PAYMENTS_EGISSO';
    case FAMILY_ASSETS                    = 'FAMILY_ASSETS';
    case PRE_RETIREMENT_AGE               = 'PRE_RETIREMENT_AGE';
    case PRE_RETIREMENT_AGE_SFR           = 'PRE_RETIREMENT_AGE_SFR';
    case MEDICAL_POLICY                   = 'MDCL_PLCY';
    case VEHICLE_REGISTRATION_CERTIFICATE = 'VEHICLE_INFO';
    case INDIVIDUAL_ENTREPRENEUR_DATA     = 'BSS_DATA';
    case ORGANIZATION_DATA                = 'ORG_DATA';
    case REAL_ESTATE                      = 'REG_REALESTATE';
    case SELF_EMPLOYED                    = 'SELF_EMPLOYED';
    case TRAFFIC_POLICE_DRIVER_LICENSE    = 'GIBDD_DRIVER_LICENSE';
    case KID_RUSSIAN_PASSPORT             = 'KID_RF_PASSPORT';
    case KID_RUSSIAN_BIRTH_CERTIFICATE    = 'KID_RF_BRTH_CERT';
    case KID_SNILS                        = 'KID_SNILS_DOC';
    case DISABLED_PERSON                  = 'DISABLED_PERSON';
    case DIGITAL_WORKBOOK                 = 'DIGITAL_WORKBOOK';

    /**
     * Значение с опечаткой (SELF_EMPLOEYD_INCOME) взято из документа «Сценарии использования инфраструктуры Цифрового профиля», табл. 8
     */
    case SELF_EMPLOYED_INCOME = 'SELF_EMPLOEYD_INCOME';
}
