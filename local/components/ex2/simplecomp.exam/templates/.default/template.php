<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<ul>
    <?foreach($arResult["SUMMARY_DATA"] as $item):?>
    <li>
        <b><?=$item["NAME"];?></b> - <?=$item["ACTIVE_FROM"]?> (<?=implode(", ", $item["SECTION"])?>)
        <ul>
            <?foreach($item["PRODUCTS"] as $product):?>
            <li>
                <?=$product["NAME"]?> - <?=$product["PRICE"]?> - <?=$product["MATERIAL"]?> - <?=$product["ARTNUMBER"]?>
            </li>
            <?endforeach;?>
        </ul>
    </li>
    <?endforeach;?>
</ul>
