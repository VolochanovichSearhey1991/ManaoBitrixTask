<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

    if ( $this->StartResultCache(false, $USER->GetGroups()) ) {

    
        $count = 0;
        $arFilterCl = ['IBLOCK_ID' => $arParams['CLASSIFIER_IBLOCK_ID'], 'CHECK_PERMISSIONS' => 'Y'];
        $arSelectCl = ['IBLOCK_ID', 'ID', 'NAME'];
        $resCl = CIBlockElement::GetList([], $arFilterCl, false, false, $arSelectCl);

        if (!$resCl) {
            $this->AbortResultCache();
        }

        while ($clData = $resCl->Fetch()) {
            $arIdCl[] = $clData['ID'];// массив id всех классификаторов для передачи в запрос(получить все товары с привязками)
            $arResult[$clData['ID']] = [$clData['NAME'], []];
            $count++;
        }

        $arFilterEl = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'PROPERTY_FIRM.ID' => $arIdCl, 'CHECK_PERMISSIONS' => 'Y']; //чтобы не делать лишних запросов в цикле одним запросом получаю все товары у которых есть ...////привязки
        $arSelectEl = ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_FIRM', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'DETAIL_PAGE_URL'];
        $resEl = CIBlockElement::GetList([], $arFilterEl, false, false, $arSelectEl);
        $resEl->SetUrlTemplates($arParams["DETAIL_URL"], "", "");

        if (!$resEl) {
            $this->AbortResultCache();
        }

        while ($elData = $resEl->GetNextElement()) {
            $bufAr = $elData->GetFields();
            $arResult[$bufAr['PROPERTY_FIRM_VALUE']][1][] = $bufAr;//id классификатора ключ массива, PROPERTY_FIRM_VALUE также содержит id классификатора, каждый товар попадет в нужный подмассив
        }
       
        $this->IncludeComponentTemplate();
    }
    
        $APPLICATION->SetTitle('Разделов: ' . $count);
?>