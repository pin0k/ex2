<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arResult["SPECIAL_DATE"]) {
    $APPLICATION->SetPageProperty("specialdate", $arResult["SPECIAL_DATE"]);
}