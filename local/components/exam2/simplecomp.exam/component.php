<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if ($this->StartResultCache()) {
	if(intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0 && intval($arParams["NEWS_IBLOCK_ID"]) > 0 && !empty($arParams["PROPERTY_CODE_BINDING"])) {
		$arResult["COUNT"] = 0;
		$arResult["SUMMARY"] = [];
		$arResult["PRICE_SCALE"] = [];
		// news
		$news = [];
		$newsORM = CIBlockElement::GetList(
			["NAME" => "ASC"], 
			[
				"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			], 
			false, 
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				"ACTIVE_FROM"
			]
		);
		while($arElement = $newsORM->Fetch()) {
			$news[] = $arElement;
		}
		
		//iblock sections	
		$sections = [];
		$sectionsORM = CIBlockSection::GetList(
			["NAME" => "ASC"], 
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			], 
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				$arParams["PROPERTY_CODE_BINDING"]
			], 
			false
		);
		while($arSection = $sectionsORM->Fetch()) {
			$sections[] = $arSection;
		}

		// products
		$products = [];
		$priceScale = [];
		$productsORM = CIBlockElement::GetList(
			["NAME" => "ASC"], 
			[
				"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y"
			], 
			false, 
			false, 
			[
				"ID",
				"IBLOCK_ID",
				"NAME",
				"IBLOCK_SECTION_ID",
				"PROPERTY_PRICE",
				"PROPERTY_MATERIAL",
				"PROPERTY_ARTNUMBER"
			]
		);
		while($arElement = $productsORM->Fetch()) {
			++$arResult["COUNT"];
			$products[$arElement["IBLOCK_SECTION_ID"]][] = [
				"ID" => $arElement["ID"],
				"NAME" => $arElement["NAME"],
				"PRICE" => $arElement["PROPERTY_PRICE_VALUE"],
				"MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
				"ARTNUMBER" => $arElement["PROPERTY_ARTNUMBER_VALUE"]
			];
			$arResult["PRICE_SCALE"][] = $arElement["PROPERTY_PRICE_VALUE"];
		}

		foreach($news as $new){
			$item = $new;
			$item["SECTION"] = [];
			$item["PRODUCTS"] = [];
			foreach($sections as $section) {
				if(in_array($new["ID"], $section["UF_NEWS_LINK"])) {
					$item["SECTION"][(int)$section["ID"]] = $section["NAME"];
					$item["PRODUCTS"] = array_merge($item["PRODUCTS"], $products[(int)$section["ID"]]); 
				}
			}
			$arResult["SUMMARY"][] = $item;
		}
		$this->SetResultCacheKeys(["COUNT", "PRICE_SCALE"]);
	} else {
		$this->AbortResultCache();
	}
	$this->includeComponentTemplate();
}	

$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_SET_TITLE", ["#COUNT#" => $arResult["COUNT"]]));