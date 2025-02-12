<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>

<ul>
    <?foreach($arResult["SUMMARY"] as $product):?>
        <li>
            <b><?=$product["NAME"]?></b> - <?=$product["ACTIVE_FROM"]?> (<?=implode(", ", $product["SECTION"])?>)
            <ul>
                <?foreach($product['PRODUCTS'] as $arProduct):?>
                    <li>
                        <?=$arProduct['NAME'];?> 
                        - <?=$arProduct['PRICE'];?> 
                        - <?=$arProduct['MATERIAL'];?> 
                        - <?=$arProduct['ARTNUMBER'];?>
                    </li>
                <?endforeach;?>    
            </ul>
        </li>
    <?endforeach;?>
</ul>