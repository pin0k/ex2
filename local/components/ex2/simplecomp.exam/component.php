<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock")) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if ($this->StartResultCache()) {
	if(intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0 && $arParams["NEWS_IBLOCK_ID"] > 0 && (!empty($arParams["CASTOM_NEW_PROPERTY"]))) {
		// echo "<pre>";
		// var_dump($arParams);
		// echo "</pre>";

		$this->$arResult['COUNT'] = 0;
		$this->$arResult['SUMMARY_DATA'] = [];
	
		//iblock news
		$news = [];
		$newsORM = CIBlockElement::GetList(
			["NAME" => "ASC"], 
			["IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
			"ACTIVE" => "Y"], 
			false, 
			false, 
			["ID", "IBLOCK_ID", "NAME", "ACTIVE_FROM"]
		);
		while($arElement = $newsORM->Fetch()) {
			$news[] = $arElement;
		}

		//iblock sections - РАЗДЕЛЫ
		$sections = [];
		$sectionsORM = CIBlockSection::GetList(
			["NAME" => "ASC"], 
			[	"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
				"ACTIVE" => "Y"], 
			false, 
			["ID", "IBLOCK_ID", "NAME", $arParams["CASTOM_NEW_PROPERTY"]], 
			false
		);
		while($arSection = $sectionsORM->Fetch()) {
			$sections[] = $arSection;
		}
	
		//iblock elements - ТОВАРЫ
		$products = [];		
		$productsORM = CIBlockElement::GetList(
			["NAME" => "ASC"], 
			["IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y"], 
			false, 
			false, 
			["ID", "IBLOCK_ID", "NAME", "PROPERTY_PRICE", "PROPERTY_MATERIAL", "PROPERTY_ARTNUMBER", "IBLOCK_SECTION_ID"]
		);
		// получаем список товаров, отсортированных по разделам
		while($arElement = $productsORM->Fetch()) {
			++$arResult['COUNT'];
			$products[(int)$arElement["IBLOCK_SECTION_ID"]][] = [
				"ID" => $arElement["ID"],
				"IBLOCK_SECTION_ID" => $arElement["IBLOCK_SECTION_ID"],
				"NAME" => $arElement["NAME"],
				"PRICE" => $arElement["PROPERTY_PRICE_VALUE"],
				"MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
				"ARTNUMBER" => $arElement["PROPERTY_ARTNUMBER_VALUE"]
			];		
		}

		// Итоговые данные
		foreach($news as $new) {
			$item = $new;
			$item["SECTION"] = [];
			$item["PRODUCTS"] = [];
			foreach($sections as $section) {
				if(in_array($new["ID"], $section["UF_NEWS_LINK"])){
					$item["SECTION"][(int)$section["ID"]] = $section["NAME"];
					$item["PRODUCTS"] = array_merge($item["PRODUCTS"], $products[(int)$section['ID']]);
				}
			}
			$arResult['SUMMARY_DATA'][] = $item;
		}
		$this->SetResultCacheKeys(['COUNT', 'SUMMARY_DATA']);				
	} else {
		$this->AbortResultCache();
	}

	$this->includeComponentTemplate();
}	

$APPLICATION->SetTitle(GetMessage('SIMPLECOMP_EXAM2_ELEM_COUNT', ['#ELEMENT_COUNT#' => $arResult['COUNT']]));