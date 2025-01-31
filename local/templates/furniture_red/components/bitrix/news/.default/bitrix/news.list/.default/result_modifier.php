<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if($arParams["SPECIAL_DATE"] == "Y") {
    $firstNews = reset($arResult["ITEMS"]);
    $arResult["SPECIAL_DATE"] = isset($firstNews["ACTIVE_FROM"]) ? $firstNews["ACTIVE_FROM"] : null;
    $this -> getComponent() -> SetResultCacheKeys(["SPECIAL_DATE"]);
}