<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();




    if ($this->StartResultCache()) {

        $countElems = 0;
        $arFilterNews = ['IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID']];
        $arSelectNews = ['IBLOCK_ID', 'ID', 'NAME', 'DATE_ACTIVE_FROM'];
        $resNews = CIBlockElement::GetList([], $arFilterNews, false, false, $arSelectNews);

        if (!$resNews) {
            $this->AbortResultCache();
        }

        while ($newsData = $resNews->Fetch()) {
            $arNewsID[] =  $newsData['ID'];
            $arResult[$newsData['ID']] = [$newsData['NAME'], $newsData['DATE_ACTIVE_FROM'], []];
        }

        $arFilterDir = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'UF_NEWS_LINK' => $arNewsID];
        $arSelectDir = ['IBLOCK_ID', 'ID', 'NAME', 'UF_NEWS_LINK'];
        $resDir = CIBlockSection::GetList([], $arFilterDir, false, $arSelectDir);

        if (!$resDir) {
            $this->AbortResultCache();
        }

        while ($dirData = $resDir->Fetch()) {
            $arDirId[] = $dirData['ID'];
            $arDirData[$dirData['ID']] = $dirData;
            
        }

        $arFilterElem = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'SECTION_ID' => $arDirId];
        $arSelectElem = ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER', 'IBLOCK_SECTION_ID'];
        $resElem = CIBlockElement::GetList([], $arFilterElem, false, false, $arSelectElem);

        if (!$resElem) {
            $this->AbortResultCache();
        }

        while ($elemData = $resElem->Fetch()) {
            $countElems++;
            $arDirData[$elemData['IBLOCK_SECTION_ID']]['elems'][] = $elemData;
        }

        foreach ($arDirData as $dir) {

            foreach ($dir['UF_NEWS_LINK'] as $property) {
                $arResult[$property][2][] = $dir;
            }

        } 

        $this->IncludeComponentTemplate();
    }
    $APPLICATION->SetTitle($countElems);
    
?>