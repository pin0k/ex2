<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

AddEventHandler("main", "OnBeforeEventAdd", array("MyClass", "OnBeforeEventAddHandler"));

class MyClass {
	public static function OnBeforeEventAddHandler(&$event, &$lid, &$arFields) {
        if($event == "FEEDBACK_FORM") {
            global $USER;

            if($USER->IsAuthorized()) {
                $arFields["AUTHOR"] = Loc::getMessage("USER_AUTORIZED", [
                    "#ID#" => $USER->GetID(),
                    "#LOGIN#" => $USER->GetLogin(),
                    "#NAME#" => $USER->GetFullName(),
                    "#USER_NAME#" => $arFields["AUTHOR"],
                ]);
            } else {
                $arFields["AUTHOR"] = Loc::getMessage("USER_NOT_AUTORIZED", [
                    "#USER_NAME#" => $arFields["AUTHOR"],
                ]);
            }
            
            CEventLog::Add(array(
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => $event,
                "MODULE_ID" => "main",
                "ITEM_ID" => 123,
                "DESCRIPTION" => Loc::getMessage("EVENT_LOG_ENTRY", [
                    '#AUTHOR#' => $arFields["AUTHOR"],
                ]),
            ));
        }	
	}
}