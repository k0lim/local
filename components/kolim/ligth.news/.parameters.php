<?php
/*
 * Файл local/components/kolim/light.news/.parameters.php
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

// проверяем, установлен ли модуль «Информационные блоки»; если да — то подключаем его
if (!CModule::IncludeModule('iblock')) {
    return;
}

/*
 * Получаем массив всех типов инфоблоков — для возможности выбора
 */
$arInfoBlockTypes = CIBlockParameters::GetIBlockTypes();

/*
 * Получаем массив инфоблоков — для возможности выбора; фильтруем их по
 * выбранному типу и по активности
 */
$arInfoBlocks = array();
$arFilter = array('ACTIVE' => 'Y');
// если уже выбран тип инфоблока, выбираем инфоблоки только этого типа
if (!empty($arCurrentValues['IBLOCK_TYPE'])) {
    $arFilter['TYPE'] = $arCurrentValues['IBLOCK_TYPE'];
}
$rsIBlock = CIBlock::GetList(
    array('SORT' => 'ASC'),
    $arFilter
);
while($iblock = $rsIBlock->Fetch()) {
    $arInfoBlocks[$iblock['ID']] = '['.$iblock['ID'].'] '.$iblock['NAME'];
}


/*
 * Настройки комлексного компонента
 */
$arComponentParameters = array( // кроме групп по умолчанию, добавляем свои группы настроек
    'GROUPS' => array(
        'ELEMENT_SETTINGS' => array(
            'NAME' => 'Настройки страницы элемента',
            'SORT' => 1000
        ),
    ),
    /*
     * Группы параметров компонента:
     * 1. Основные параметры компонента (BASE)
     * 2. Параметры главной страницы (POPULAR_SETTINGS)
     * 3. Параметры страницы раздела (SECTION_SETTINGS)
     * 4. Параметры страницы элемента (DETAIL_SETTINGS)
     */
    'PARAMETERS' => array(

        /*
         * 1. Основные параметры компонента
         */
        'IBLOCK_TYPE' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Тип инфоблока',
            'TYPE' => 'LIST',
            'VALUES' => $arInfoBlockTypes,
            'REFRESH' => 'Y',
        ),
        'IBLOCK_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Инфоблок',
            'TYPE' => 'LIST',
            'VALUES' => $arInfoBlocks,
            'REFRESH' => 'Y',
        ),
        // использовать символьный код вместо ID; если отмечен этот checkbox, в
        // визуальном редакторе надо будет обязательно изменить шаблоны ссылок
        // при включенном режиме поддержки ЧПУ, чтобы вместо #SECTION_ID# и
        // #ELEMENT_ID# использовались #SECTION_CODE# и #ELEMENT_CODE#
        'USE_CODE_INSTEAD_ID' => array(
            'PARENT' => 'BASE',
            'NAME' => 'Использовать символьный код вместо ID',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'N',
        ),
        /*
         * 2. Параметры главной страницы
         */

        /*
         * 3. Параметры страницы раздела
         */


        /*
         * 4. Параметры страницы элемента
         */

        /*
         * Это отдельный блок настроек, который задает работу
         * в обычном режиме (без ЧПУ) и в режиме ЧПУ
         */
        'VARIABLE_ALIASES' => array( // это для работы в режиме без ЧПУ
            'ELEMENT_ID' => array('NAME' => 'Идентификатор элемента'),
            'ELEMENT_CODE' => array('NAME' => 'Символьный код элемента'),
        ),
        'SEF_MODE' => array( // это для работы в режиме ЧПУ
            'list' => array(
                'NAME' => 'Главная страница',
                'DEFAULT' => '',
            ),
            'element' => array(
                'NAME' => 'Страница элемента',
                'DEFAULT' => 'item/id/#ELEMENT_ID#/',
            ),
        ),

        /*
         * Настройки кэширования
         */
        'CACHE_TIME'  =>  array('DEFAULT' => 3600),
        'CACHE_GROUPS' => array( // учитываться права доступа при кешировании?
            'PARENT' => 'CACHE_SETTINGS',
            'NAME' => 'Учитывать права доступа',
            'TYPE' => 'CHECKBOX',
            'DEFAULT' => 'Y',
        ),
    ),
);


// настройки на случай, если раздел или элемент не найдены, 404 Not Found
CIBlockParameters::Add404Settings($arComponentParameters, $arCurrentValues);
