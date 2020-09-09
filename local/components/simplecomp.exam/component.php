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
            $arFilterDir = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'UF_NEWS_LINK' => $newsData['ID']];
            $arSelectDir = ['IBLOCK_ID', 'ID', 'NAME', 'UF_NEWS_LINK'];
            $resDir = CIBlockSection::GetList([], $arFilterDir, false, $arSelectDir);

            if (!$resDir) {
                $this->AbortResultCache();
            }

            while ($dirData = $resDir->Fetch()) {
                $arFilterElem = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'ACTIVE' => 'Y', 'SECTION_ID' => $dirData['ID']];
                $arSelectElem = ['IBLOCK_ID', 'ID', 'NAME', 'PROPERTY_PRICE', 'PROPERTY_MATERIAL', 'PROPERTY_ARTNUMBER'];
                $resElem = CIBlockElement::GetList([], $arFilterElem, false, false, $arSelectElem);

                if (!$resElem) {
                    $this->AbortResultCache();
                }

                while ($elemData = $resElem->Fetch()) {
                    $arElemData[] = $elemData;
                    $countElems++;
                }

                $arDirData[] = [$dirData['ID'], $dirData['NAME'], $arElemData];
                $arElemData = [];
            }

            
                $arResult[$newsData['ID']] = [$newsData['NAME'], $newsData['DATE_ACTIVE_FROM'], $arDirData];
                $arDirData = [];
            
            
        }

        $this->IncludeComponentTemplate();
    }
    $APPLICATION->SetTitle($countElems);
    
?>