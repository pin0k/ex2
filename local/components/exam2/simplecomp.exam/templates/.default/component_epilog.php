<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!empty($arResult["PRICE_SCALE"])) {
    $APPLICATION->AddViewContent("SIMPLECOMP_PRICE_SCALE", GetMessage("SIMPLECOMP_PRICE_SCALE", [
        "#MAX#" => max($arResult["PRICE_SCALE"]) == NULL ? 0 : max($arResult["PRICE_SCALE"]),
        "#MIN#" => min($arResult["PRICE_SCALE"]) == NULL ? 0 : min($arResult["PRICE_SCALE"]),
    ]));
}    
?>