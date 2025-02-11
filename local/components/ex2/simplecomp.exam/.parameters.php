<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"CASTOM_NEW_PROPERTY" => array(
			"NAME" => GetMessage("CASTOM_NEW_PROPERTY"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME" => array("DEFAULT" => 3600)
	),
);