<?php
/*
 * Файл local/components/kolim/light.news/templates/.default/list.php
 */
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

$this->setFrameMode(true);
?>

<?php
echo "this is list page";
$APPLICATION->IncludeComponent(
    'kolim:light.news.list',
    '',
    Array(
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],             // тип инфоблока
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],                 // идентификатор инфоблока

        //  использовать символьные коды вместо идентификаторов
        'USE_CODE_INSTEAD_ID' => $arParams['USE_CODE_INSTEAD_ID'],

        // URL, ведущий на страницу с содержимым элемента
        'ELEMENT_URL' => $arResult['ELEMENT_URL'],

        // настройки кэширования
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
    ),
    $component
);
?>
