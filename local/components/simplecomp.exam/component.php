<?
    if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

     
    $i = 0;
    $arFilter = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID']];
    $arSelect = ['IBLOCK_ID','ID','NAME','UF_NEWS_LINK'];
    $resProd = CIBlockSection::GetList(['sort' => 'asc'], $arFilter, false, $arSelect);

     while ($groupsData = $resProd->Fetch()) {

        $arGroupsData[] = $groupsData;

         foreach ($groupsData['UF_NEWS_LINK'] as $newsId) {

            $arFilterNews = ['IBLOCK_ID' => $arParams['NEWS_IBLOCK_ID'], 'ID' => $newsId];
            $arSelectNews = ['IBLOCK_ID','ID','NAME'];
            $resNews = CIBlockElement::GetList(['sort' => 'asc'], $arFilterNews, false, false, $arSelectNews);

            if ($newsData = $resNews->Fetch()) {

                $arGroupsData[$i] = [$newsData['NAME'], $groupsData['NAME']];

                $arFilterElems = ['IBLOCK_ID' => $arParams['CATALOG_IBLOCK_ID'], 'SECTION_ID' => $groupsData['ID']];
                $arSelectElems = ['IBLOCK_ID','ID','NAME'];
                $resElems = CIBlockElement::GetList(['sort' => 'asc'], $arFilterElems, false, false, $arSelectElems);

                while ($elemsData = $resElems->Fetch()) {
                    $buf[] = $elemsData['NAME'];
                }
                
                $arGroupsData[$i][2] = $buf;
                $arGroupsData[$i][3] = $groupsData['ID'];
                $buf = [];
                $i++;
            } 
            
        }  
        
        
        
    } 

    /* while ($groupsData = $resProd->Fetch()) {

       
            $arGroupsData[] = $groupsData['UF_NEWS_LINK'];
        

        
    } */

   echo "<pre>";
    print_r($arGroupsData);
    echo '</pre>';

?>