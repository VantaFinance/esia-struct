<?php
/**
 * ESIA Struct
 *
 * @author    Vlad Shashkov <v.shashkov@pos-credit.ru>
 * @copyright Copyright (c) 2024, The Vanta
 */

declare(strict_types=1);

namespace Vanta\Integration\Esia\Struct;

/**
 * @see https://digital.gov.ru/uploaded/presentations/finalstsenariiispolzovaniyatspv131.pdf
 */
enum Permission: string
{
    case OPEN_ID = 'openid';

    /**
     * Фамилия; имя; отчество
     */
    case FULL_NAME = 'fullname';

    /**
     * Дата рождения, указанная в УЗ
     */
    case BIRTHDATE = 'birthdate';

    /**
     * Место рождения
     */
    case BIRTHPLACE = 'birthplace';

    /**
     * Пол, указанный в УЗ
     */
    case GENDER = 'gender';

    /**
     * Адрес электронной почты, указанный в УЗ
     */
    case EMAIL = 'email';

    /**
     * Номер мобильного телефона
     */
    case MOBILE = 'mobile';

    /**
     * Адреса постоянной регистрации, временной регистрации (доступен только с версией API v2) и фактического проживания
     */
    case ADDRESSES = 'addresses';

    /**
     * Государственный регистрационный знак; серия и номер свидетельства о регистрации
     */
    case VEHICLES = 'vehicles';

    /**
     * СНИЛС, указанный в УЗ
     */
    case SNILS = 'snils';

    /**
     * ИНН, указанный в УЗ
     */
    case INN = 'inn';

    /**
     * Серия и номер документа, удостоверяющего личность; дата выдачи; кем выдан; код подразделения; гражданство
     */
    case ID_DOC = 'id_doc';

    /**
     * Фамилия, имя, отчество буквами латинского алфавита; серия и номер заграничного паспорта; дата выдачи; срок действия; орган, выдавший документ; гражданство
     */
    case FOREIGN_PASSPORT_DOC = 'foreign_passport_doc';

    /**
     * История паспортов
     */
    case PASSPORT_HISTORY_DOC = 'history_passport_doc';

    /**
     * Серия и номер водительского удостоверения; дата выдачи; срок действия
     */
    case DRIVERS_LICENSE_DOC = 'drivers_licence_doc';

    /**
     * Сведения о свидетельствах о регистрации ТС гражданина
     */
    case VEHICLE_REGISTRATION_CERTIFICATE_DOC = 'vehicle_reg_cert_doc';

    /**
     * Серия и номер свидетельства; дата выдачи; место государственной регистрации
     */
    case BIRTH_CERTIFICATE_DOC = 'birth_cert_doc';

    /**
     * Свидетельство о перемене имени
     */
    case CHANGE_FULL_NAME_CERTIFICATE_DOC = 'change_fullname_cert_doc';

    /**
     * Свидетельство о браке
     */
    case DEATH_CERTIFICATE_DOC = 'death_cert_doc';

    /**
     * Свидетельство о браке
     */
    case MARRIAGE_CERTIFICATE_DOC = 'marriage_cert_doc';

    /**
     * Свидетельство о разводе
     */
    case DIVORCE_CERTIFICATE_DOC = 'divorce_cert_doc';

    /**
     * Свидетельство об установлении отцовства
     */
    case PATERNITY_CERTIFICATE_DOC = 'paternity_cert_doc';

    /**
     * выписка из ИЛС СФР
     */
    case ILS_PFR_DOC = 'ils_doc';

    /**
     * Справка о доходах и суммах налога ФЛ (форма 2-НДФЛ)
     */
    case NDFL_PERSON = 'ndfl_person';

    /**
     * Сведения о трудовой деятельности застрахованного лица в системе обязательного пенсионного страхования
     */
    case ELECTRONIC_WORKBOOK = 'electronic_workbook';

    /**
     * Сведения о статусе самозанятого
     */
    case SELF_EMPLOYED = 'self_employed';

    /**
     * Сведения об отнесении гражданина к категории граждан предпенсионного возраста
     */
    case PRE_RETIREMENT_AGE = 'pre_retirement_age';

    /**
     * Сведения о назначенных и реализованных мерах социальной защиты (поддержки)
     */
    case PAYMENTS_EGISSO = 'payments_egisso';

    /**
     * Сведения о доходах ФЛ и о выплатах страховых взносов, произведенных в пользу ФЛ
     */
    case PAYOUT_INCOME = 'payout_income';

    /**
     * Справка о назначенных пенсиях и социальных выплатах на дату
     */
    case PENSION_REFERENCE = 'pension_reference';

    /**
     * Данные об объектах недвижимости, находящихся в собственности
     */
    case reg_realestate = 'reg_realestate';

    /**
     * Связь УЗ ЕСИА с внешними ИС
     */
    case LINK = 'link';

    /**
     * Информация о банковских реквизитах для получения мер социальной поддержки
     */
    case BANK_ACCOUNT = 'bank_account';

    /**
     * Семейное положение субъекта персональных данных
     */
    case FAMILY_STATUS_EXT = 'family_status_ext';

    /**
     * Образование субъекта персональных данных
     */
    case EDUCATION_EXT = 'education_ext';

    /**
     * Профессия субъекта персональных данных
     */
    case PROFESSION_EXT = 'profession_ext';

    /**
     * Социальное положение субъекта персональных данных
     */
    case SOCIAL_STATUS_EXT = 'social_status_ext';

    /**
     * Доход субъекта персональных данных
     */
    case INCOME_EXT = 'income_ext';

    /**
     * Место рождения субъекта персональных данных
     */
    case BIRTHPLACE_EXT = 'birthplace_ext';

    /**
     * Расовая принадлежность субъекта персональных данных
     */
    case RACE_EXT = 'race_ext';

    /**
     * Политические взгляды субъекта персональных данных
     */
    case POLITICALLY_EXT = 'politically_ext';

    /**
     * Религиозные убеждения субъекта персональных данных
     */
    case RELIGION_EXT = 'religion_ext';

    /**
     * Философские убеждения субъекта персональных данных
     */
    case PHILOSOPHY_EXT = 'philosophy_ext';

    /**
     * Состояние здоровья субъекта персональных данных
     */
    case HEALTH_EXT = 'health_ext';

    /**
     * Интимная жизнь субъекта персональных данных
     */
    case INTIMACY_EXT = 'intimacy_ext';

    /**
     * Судимость субъекта персональных данных
     */
    case CONVICTION_EXT = 'conviction_ext';

    /**
     * Биометрические данные субъекта персональных данных
     */
    case BIOMETRIC_EXT = 'biometric_ext';

    /**
     * Дата рождения субъекта персональных данных
     */
    case BIRTHDATE_EXT = 'birthdate_ext';

    /**
     * персональные биометрические данные передаваемые из ГИС ЕБС в КБС
     */
    case BIO_EXPORT = 'bio_export';

    /**
     * Адрес субъекта персональных данных
     */
    case ADDRESS_EXT = 'address_ext';

    /**
     * Адрес электронной почты субъекта персональных данных
     */
    case EMAIL_EXT = 'email_ext';

    /**
     * Номер мобильного телефона субъекта персональных данных
     */
    case MOBILE_EXT = 'mobile_ext';

    /**
     * Фамилия, имя, отчество (при наличии) субъекта персональных данных
     */
    case FULLNAME_EXT = 'fullname_ext';

    /**
     * Пол ребенка
     */
    case KID_GENDER = 'kid_gender';

    /**
     * СНИЛС ребенка
     */
    case KID_SNILS = 'kid_snils';

    /**
     * Дата рождения ребенка
     */
    case KID_BIRTHDATE = 'kid_birthdate';

    /**
     * Фамилия, имя, отчество (при наличии) ребенка
     */
    case KID_FULLNAME = 'kid_fullname';

    /**
     * Сведения об обучении ребенка (подопечного) в школе (СНИЛС ребенка (подопечного),
     * наименование школы, класс, периоды обучения, успеваемость,
     * посещаемость, расписание уроков, сведения о домашнем задании)
     */
    case KID_SCHOOL_DATA = 'kid_school_data';

    /**
     * Сведения о свидетельстве о рождении ребенка
     */
    case KID_BIRTH_CERT_DOC = 'kid_birth_cert_doc';

    /**
     * ИНН ребенка
     */
    case KID_INN = 'kid_inn';

    /**
     * Просмотр сведений о страховании детей в системе ОМС, их полисе, прикреплении к медицинским организациям,
     * стоимости и оплате оказанной им медицинской помощи, полученной в рамках программы ОМС
     */
    case KID_MEDICAL_DOC = 'kid_medical_doc';

    /**
     * Просмотр номера телефона ребе
     */
    case KID_MOBILE = 'kid_mobile';

    /**
     * Просмотр электронной почты ребенка
     */
    case KID_EMAIL = 'kid_email';

    /**
     * Документы об образовании
     */
    case EDUCATIONAL_DOC = 'educational_doc';

    /**
     * Результаты ЕГЭ
     */
    case EGE_RESULT = 'ege_result';

    /**
     * Данные об остатке материнского капитала
     */
    case FAMILY_ASSETS_BALANCE = 'family_assets_balance';

    /**
     * Сведения ЕГИССО об изменении дееспособности граждан
     */
    case LEGALCAPACITY = 'legalcapacity';

    /**
     * Сведения о ГРЗ ТС гражданина
     */
    case NUMBER_PLATE_DOC = 'number_plate_doc';

    /**
     * Данные о достижениях в олимпиадах
     */
    case OLYMPICS = 'olympics';

    /**
     * Полис ОСАГО
     */
    case OSAGO_POLICY = 'osago_policy';

    /**
     * Сведения из ЕГР ЗАГС
     */
    case REGISTRY_OFFICE_DATA = 'registry_office_data';

    /**
     * Сведения об электронных медицинских документах, полученных в медицинских организациях, в том числе
     * протоколы консультаций, справки и выписки, результаты исследований и направления
     */
    case REMD_MEDICAL_DOC = 'remd_medical_doc';

    /**
     * Информация о возможном возникновении прав на меры социальной поддержки
     */
    case SOCIAL_SUPPORT_INFO = 'social_support_info';

    /**
     * Данные цифрового студенческого билета пользователя
     */
    case STUDENT_TICKET = 'student_ticket';

    /**
     * Статус подтверждения учетной записи
     */
    case VOLUNTEER_ACTIVITY = 'volunteer_activity';

    /**
     * Данные вашего вида на жительство
     */
    case RESIDENCE_DOC = 'residence_doc';
}
